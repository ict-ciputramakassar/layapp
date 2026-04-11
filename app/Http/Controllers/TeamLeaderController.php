<?php

namespace App\Http\Controllers;

use App\Models\CategoryAge;
use App\Models\MemberType;
use App\Models\Position;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\TeamMember; // Sesuaikan dengan nama Model Anda
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TeamLeaderController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function getMembers()
    {
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $this->user->team;

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
                    'name' => $member->categoryAge?->name,
                    'code' => $member->categoryAge?->code,
                    'id' => $member->categoryAge?->id,
                ],
                'dob' => $member->dob,
                'phone_number' => $member->phone_number,
                'email' => $member->email,
                'height' => $member->height,
                'weight' => $member->weight,
                'position' => [
                    "name" => $member->position?->name,
                    "code" => $member->position?->code,
                    "id" => $member->position?->id,
                ],
                'license' => [
                    "name" => $member->license ?? "",
                    "valid_date" => $member->valid_date ?? "",
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'members' => $mappedMembers,
        ]);
    }

    public function addMembersBulk(Request $request)
    {
        // 1. Validasi Data
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
                    'distinct',
                    Rule::unique('m_team_member', 'email')->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
                'members.*.height' => 'required|numeric',
                'members.*.weight' => 'required|numeric',
                'members.*.member_type_id' => 'required|string',
                'members.*.image' => 'required|image|mimes:jpeg,png,jpg|max:2048',

                // UBAH MENJADI NULLABLE: 
                // Karena jika yang dipilih Player, License & Valid Date akan kosong.
                // Jika yang dipilih Coach, Position & Category Age akan kosong.
                'members.*.type_code' => 'required|string',
                'members.*.license' => 'required_if:type_code,CO|nullable|string|max:1',
                'members.*.valid_date' => 'required_if:type_code,CO|nullable|date',
                'members.*.position_id' => 'required_if:type_code,AT|nullable|string',
                'members.*.category_age_id' => 'required_if:type_code,AT|nullable|string',

                // start_date dan end_date DIHAPUS dari validasi karena dibuat di controller
            ],
            [
                'members.*.email.distinct' => 'Duplicate emails exist inside the table.',
                'members.*.email.unique' => 'This email has been used.'
            ]
        );

        // Cek Otorisasi User
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $this->user->team;
        $uploadedImages = [];

        // SET TANGGAL OTOMATIS (Sekarang dan 2 Tahun dari Sekarang)
        $startDate = Carbon::now()->format('Y-m-d');
        $endDate = Carbon::now()->addYears(2)->format('Y-m-d');

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 3. Looping data yang dikirim dari JS
            foreach ($request->members as $memberData) {

                $imagePath = null;

                // Upload Gambar
                if (isset($memberData['image']) && $memberData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $memberData['image']->store('members', 'public');
                    $uploadedImages[] = $imagePath;
                }

                // Simpan ke database
                TeamMember::create([
                    'team_id' => $team->id,
                    'created_by' => $this->user->id,
                    'modified_by' => $this->user->id,
                    'full_name' => $memberData['full_name'],
                    'dob' => $memberData['dob'],
                    'phone_number' => $memberData['phone_number'],
                    'email' => $memberData['email'],
                    'height' => $memberData['height'],
                    'weight' => $memberData['weight'],
                    'member_type_id' => $memberData['member_type_id'],
                    'image' => $imagePath,

                    // Gunakan null coalescing operator (??) untuk mencegah error jika key tidak ada
                    'license' => $memberData['license'] ?? null,
                    'valid_date' => $memberData['valid_date'] ?? null,
                    'position_id' => $memberData['position_id'] ?? null,
                    'category_age_id' => $memberData['category_age_id'] ?? null,

                    // Masukkan tanggal yang di-generate otomatis dari controller
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }

            // Jika semua berhasil, simpan permanen ke database
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'All team members have been successfully saved.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus gambar jika terjadi error
            foreach ($uploadedImages as $path) {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            Log::error('Bulk Insert Member Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving to the database. ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTeams()
    {
        $teams = Team::all();
        $mappedTeams = $teams->map(function ($team) {
            if ($team->is_active) {
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

                return [
                    "id" => $team->id,
                    "name" => $team->name,
                    'members' => $mappedMembers
                ];
            }
        });

        return response()->json([
            'success' => true,
            'teams' => $mappedTeams,
        ]);
    }

    public function addMemberView()
    {

        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return redirect('auth.login');
        }

        $data = [
            "types" => MemberType::all(['id', 'name', 'code']),
            "positions" => Position::all(['id', 'name', 'code']),
            "age_categories" => CategoryAge::all(['id', 'name', 'code']),
        ];
        return view('views_backend.team_leader.add_team_member', $data);
    }

    public function viewTeamMembers()
    {
        return view('views_backend.team_leader.team_members', ["user" => $this->user]);
    }
}
