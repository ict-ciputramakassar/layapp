<?php

namespace App\Http\Controllers;

use App\Models\CategoryAge;
use App\Models\MemberType;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\TeamMember; // Sesuaikan dengan nama Model Anda
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class TeamLeaderController extends Controller
{
    public function getMembers()
    {
        // $user = Auth::user();
        $user = User::where("id", "17258d88-31c2-11f1-8cba-a036bc3bed8f")->first();

        if (!$user || $user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $user->team;

        $mappedMembers = $team->teamMembers->map(function ($member) {
            // if($member->is_active == 1)
            return [
                'id' => $member->id,
                'full_name' => $member->full_name,
                'start_date' => $member->start_date,
                'end_date' => $member->end_date,
                'is_active' => $member->is_active,
                'image' => $member->image,
                'member_type' => [
                    'name' => $member->memberType->name,
                    'code' => $member->memberType->code,
                    'id' => $member->memberType->id,
                ],
                'age_category' => [
                    'name' => $member->categoryAge->name,
                    'code' => $member->categoryAge->code,
                    'id' => $member->categoryAge->id,
                ],
                'dob' => $member->dob,
                'phone_number' => $member->phone_number,
                'email' => $member->email,
                'height' => $member->height,
                'weight' => $member->weight,
                'position' => [
                    "name" => $member->position->name,
                    "code" => $member->position->code,
                    "id" => $member->position->id,
                ],
                'license' => [
                    "name" => $member->license,
                    "valid_date" => $member->valid_date,
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'team' => [
                "id" => $team->id,
                "name" => $team->name,
            ],
            'members' => $mappedMembers,
        ]);
    }

    public function addMembersBulk(Request $request)
    {
        // 1. Validasi Data
        // Memastikan request 'members' ada, berupa array, dan memvalidasi isinya
        $request->validate(
            [
                'members' => 'required|array',
                'members.*.full_name' => 'required|string|max:255',
                'members.*.dob' => 'required|date',
                'members.*.phone_number' => 'required|string|max:20',
                'members.*.email' => [
                    'required',
                    'email',
                    'max:255',
                    'distinct', // Mencegah email kembar di dalam form array yang dikirim
                    // Ganti 'm_team_member' dengan nama tabel asli Anda jika berbeda
                    Rule::unique('m_team_member', 'email')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
                'members.*.height' => 'required|numeric',
                'members.*.weight' => 'required|numeric',
                'members.*.license' => 'required|string|max:1',
                'members.*.valid_date' => 'required|date',
                'members.*.member_type_id' => 'required|string', // Sesuai value UUID dari HTML
                'members.*.position_id' => 'required|string',
                'members.*.category_age_id' => 'required|string',
                'members.*.start_date' => 'required|date',
                'members.*.end_date' => 'required|date|after_or_equal:members.*.start_date',
                'members.*.image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            ],
            [
                'members.*.email.distinct' => 'Duplicate emails exist inside the table.',
                'members.*.email.unique' => 'This email has been used.'
            ]
        );

        // Array untuk menyimpan path gambar, berguna jika terjadi error dan harus dihapus
        $uploadedImages = [];

        // $user = Auth::user();
        $user = User::where("id", "17258d88-31c2-11f1-8cba-a036bc3bed8f")->first();

        if (!$user || $user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $user->team;

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 3. Looping data yang dikirim dari JS
            foreach ($request->members as $memberData) {

                $imagePath = null;

                // Upload Gambar ke folder storage/app/public/members
                if (isset($memberData['image']) && $memberData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $memberData['image']->store('members', 'public');
                    $uploadedImages[] = $imagePath; // Simpan path untuk track record
                }

                // Simpan ke database
                TeamMember::create([
                    'team_id' => $team->id,
                    'created_by' => $user->id,
                    'modified_by' => $user->id,
                    'full_name' => $memberData['full_name'],
                    'dob' => $memberData['dob'],
                    'phone_number' => $memberData['phone_number'],
                    'email' => $memberData['email'],
                    'height' => $memberData['height'],
                    'weight' => $memberData['weight'],
                    'license' => $memberData['license'],
                    'valid_date' => $memberData['valid_date'],
                    'member_type_id' => $memberData['member_type_id'],
                    'position_id' => $memberData['position_id'],
                    'category_age_id' => $memberData['category_age_id'],
                    'start_date' => $memberData['start_date'],
                    'end_date' => $memberData['end_date'],
                    'image' => $imagePath,
                ]);
            }

            // Jika semua berhasil, simpan permanen ke database
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'All team members have been successfully saved.'
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi error pada database (misal struktur kolom tidak pas)
            DB::rollBack();

            // Hapus semua gambar yang sudah terlanjur di-upload di perulangan sebelumnya
            foreach ($uploadedImages as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // Catat error aslinya di log Laravel untuk keperluan debugging
            Log::error('Bulk Insert Member Error: ' . $e->getMessage());

            // Kembalikan response error ke frontend AJAX
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving to the database. ' . $e->getMessage()
            ], 500);
        }
    }

    public function addMemberView()
    {
        // $user = Auth::user();
        $user = User::where("id", "17258d88-31c2-11f1-8cba-a036bc3bed8f")->first();

        if (!$user || $user->userType?->code !== 'TL') {
            return redirect('auth.login');
        }

        $data = [
            "types" => MemberType::all(['id', 'name', 'code']),
            "positions" => Position::all(['id', 'name', 'code']),
            "age_categories" => CategoryAge::all(['id', 'name', 'code']),
        ];
        return view('views_backend.team_leader.add_team_member', $data);
    }
}
