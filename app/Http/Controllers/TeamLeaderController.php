<?php

namespace App\Http\Controllers;

use App\Models\CategoryAge;
use App\Models\MemberType;
use App\Models\Position;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\TeamMember; // Sesuaikan dengan nama Model Anda
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TeamLeaderController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function getMembers(Request $request)
    {
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $this->user->team;

        // 1. Mulai Query
        $query = TeamMember::with(['memberType', 'categoryAge', 'position'])
            ->where('team_id', $team->id);

        // 2. Tangkap Filter Status (Selalu dikirim)
        $status = $request->query('status', '1');
        if ($status !== 'both') {
            $query->where('is_active', $status);
        }

        // 3. Tangkap Filter Dinamis (Hanya salah satu yang akan terisi)
        if ($request->filled('full_name')) {
            $query->where('full_name', 'LIKE', '%' . $request->full_name . '%');
        }

        if ($request->filled('member_type')) {
            $query->where('member_type_id', $request->member_type);
        }

        if ($request->filled('dob_year')) {
            $query->whereYear('dob', $request->dob_year);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        // 4. Ambil Data
        $members = $query->orderBy('created_date', 'desc')->get();
        $mappedMembers = $members->map(function ($member) {
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
            'members' => $mappedMembers
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
                    $extension = $memberData['image']->getClientOriginalExtension();
                    $filename = Str::uuid() . '.' . $extension;
                    $memberData['image']->move(public_path('images/upload/members/'), $filename);
                    $imagePath = 'images/upload/members/' . $filename;
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
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
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
                return [
                    "id" => $team->id,
                    "name" => $team->name,
                    "image" => $team->image,
                    // 'members' => $mappedMembers
                ];
            }
        });

        return response()->json([
            'success' => true,
            'teams' => $mappedTeams,
        ]);
    }

    public function viewTeamDetails($id)
    {
        // Gunakan findOrFail agar otomatis memunculkan 404 jika ID tim tidak valid
        // Lakukan Eager Loading ('members') agar tidak terjadi N+1 Query Problem
        $teamData = Team::with('teamMembers')->findOrFail($id);

        // Ambil semua member dari tim tersebut ke dalam bentuk Collection
        $allMembers = $teamData->teamMembers;

        // 1. Filter & Map Athlete (Depannya "AT")
        $athletes = $allMembers->filter(function ($member) {
            return str_starts_with($member->memberType->code, 'AT');
        })->map(function ($member) {
            // Mapping key dan value untuk frontend
            return [
                'id'         => $member->id,
                'full_name'  => $member->full_name,
                'image'      => $member->image,
                'position'   => $member->position->name ?? '',
                'type'       => $member->memberType->name
            ];
        })->values();

        // 2. Filter & Map Coach (Depannya "CO" atau "ACO")
        $coaches = $allMembers->filter(function ($member) {
            return str_starts_with($member->memberType->code, 'CO') || str_starts_with($member->memberType->code, 'ACO');
        })->map(function ($member) {
            return [
                'id'         => $member->id,
                'full_name'  => $member->full_name,
                'image'      => $member->image,
                'type'       => $member->memberType->name
            ];
        })->values();

        // 3. Filter & Map Official (Sisanya)
        $officials = $allMembers->filter(function ($member) {
            return !str_starts_with($member->memberType->code, 'AT') &&
                !str_starts_with($member->memberType->code, 'CO') &&
                !str_starts_with($member->memberType->code, 'ACO');
        })->map(function ($member) {
            return [
                'id'         => $member->id,
                'full_name'  => $member->full_name,
                'image'      => $member->image,
                'type'       => $member->memberType->name
            ];
        })->values();

        // Susun data untuk dilempar ke View
        $data = [
            "team" => [
                "id" => $teamData->id,
                "name" => $teamData->name,
                "image" => $teamData->image,
                "type" => $teamData->teamType->name,
            ],
            "members" => [
                "athletes" => $athletes,
                "coaches" => $coaches,
                "officials" => $officials,
            ]
        ];

        return view('views_frontend.team_details', $data);
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
        $data = [
            "user" => $this->user,
            "types" => MemberType::all(['id', 'name', 'code']),
        ];
        return view('views_backend.team_leader.team_members', $data);
    }

    // Method untuk menampilkan halaman Edit
    public function editMemberView($id)
    {
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return redirect('auth.login');
        }
        $team = $this->user->team;

        $data = [
            "types" => MemberType::all(['id', 'name', 'code']),
            "positions" => Position::all(['id', 'name', 'code']),
            "age_categories" => CategoryAge::all(['id', 'name', 'code']),
            "member" => $member = TeamMember::where('id', $id)->where('team_id', $team->id)->firstOrFail(),
        ];

        return view('views_backend.team_leader.edit_team_member', $data);
    }

    public function updateMember(Request $request, $id)
    {
        // 1. Cek Otorisasi User
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $this->user->team;

        // 2. Cari Data Member & Pastikan member ini milik tim dari TL yang sedang login
        $member = TeamMember::where('id', $id)->where('team_id', $team->id)->firstOrFail();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found or you do not have permission to edit this member.'
            ], 404);
        }

        // 3. Validasi Data
        $request->validate(
            [
                'full_name'       => 'required|string|max:255',
                'dob'             => 'required|date',
                'phone_number'    => 'required|string|max:20',
                'email'           => [
                    'required',
                    'email',
                    'max:255',
                    // Abaikan ID member ini saat mengecek keunikan email
                    Rule::unique('m_team_member', 'email')->ignore($member->id)->where(function ($query) {
                        return $query->where('is_active', 1);
                    }),
                ],
                'height'          => 'required|numeric',
                'weight'          => 'required|numeric',
                'member_type_id'  => 'required|string',

                // Image dibuat nullable karena user mungkin tidak ingin mengganti foto
                'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

                'type_code'       => 'required|string',
                'license'         => 'required_if:type_code,CO|nullable|string|max:1',
                'valid_date'      => 'required_if:type_code,CO|nullable|date',
                'position_id'     => 'required_if:type_code,AT|nullable|string',
                'category_age_id' => 'required_if:type_code,AT|nullable|string',
            ],
            [
                'email.unique' => 'This email has been used by another active member.'
            ]
        );

        // Variabel penampung untuk gambar
        $newImagePath = null;
        $oldImagePath = $member->image; // Simpan path gambar lama

        // 4. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 5. Handle Upload Gambar Baru (Jika Ada)
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename = Str::uuid() . '.' . $extension;
                $request->file('image')->move(public_path('images/upload/members/'), $filename);
                $newImagePath = 'images/upload/members/' . $filename;
            }

            // 6. Siapkan Data Update & Cleansing Data
            // Jika tipe adalah Coach (CO), kosongkan data Athlete. Jika Athlete (AT), kosongkan data Coach.
            $isCoach = $request->type_code === 'CO';
            $isAthlete = $request->type_code === 'AT';

            $updateData = [
                'modified_by'     => $this->user->id,
                'full_name'       => $request->full_name,
                'dob'             => $request->dob,
                'phone_number'    => $request->phone_number,
                'email'           => $request->email,
                'height'          => $request->height,
                'weight'          => $request->weight,
                'member_type_id'  => $request->member_type_id,

                // Logika Cleansing
                'license'         => $isCoach ? $request->license : null,
                'valid_date'      => $isCoach ? $request->valid_date : null,
                'position_id'     => $isAthlete ? $request->position_id : null,
                'category_age_id' => $isAthlete ? $request->category_age_id : null,
            ];

            // Jika ada gambar baru, masukkan ke array update
            if ($newImagePath) {
                $updateData['image'] = $newImagePath;
            }

            // 7. Lakukan Update ke Database
            $member->update($updateData);

            // 8. Commit Database
            DB::commit();

            // 9. Hapus Gambar Lama JIKA ada gambar baru yang berhasil diupload dan disimpan
            if ($newImagePath && $oldImagePath) {
                $fullPath = public_path($oldImagePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Team member has been successfully updated.'
            ], 200);
        } catch (\Exception $e) {
            // Rollback Database
            DB::rollBack();

            // Jika error terjadi, HAPUS gambar BARU yang terlanjur terupload (agar tidak jadi sampah)
            if ($newImagePath && file_exists(public_path($newImagePath))) {
                unlink(public_path($newImagePath));
            }

            Log::error('Update Member Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the database. ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteMember($id)
    {
        // 1. Cek Otorisasi User
        if (!$this->user || $this->user->userType?->code !== 'TL') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a Team Leader or not found.'
            ], 403);
        }

        $team = $this->user->team;

        // 2. Cari Data Member & Pastikan member ini milik tim dari TL yang sedang login
        $member = TeamMember::where('id', $id)->where('team_id', $team->id)->firstOrFail();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found or you do not have permission to delete this member.'
            ], 404);
        }

        DB::beginTransaction();

        try {
            $member->update(['is_active' => 0]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Team member has been successfully deleted.',
                'member' => $member,
            ], 200);
        } catch (\Exception $e) {
            // Rollback Database
            DB::rollBack();

            Log::error('Delete Member Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the member. ' . $e->getMessage()
            ], 500);
        }
    }
}
