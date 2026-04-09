<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use App\Models\TeamType;
use App\Models\UserType;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team; // Pastikan Model Team sudah ada
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signup()
    {
        $data = [
            "types" => TeamType::all(['id', 'name', 'code']),
            "cities" => City::where('is_active', 1)->get(['id', 'name']),
            "provinces" => Province::where('is_active', 1)->get(['id', 'name']),
            "roles" => UserType::whereNot('code', 'SA')->whereNot('code', 'A')->get(['id', 'name']),
        ];
        return view("views_backend.auth.signup", $data);
    }

    public function register(Request $request)
    {
        // 1. Validasi Inputan Form
        $request->validate([
            // Validasi Personal Information (Wajib untuk semua)
            'fullName'        => 'required|string|max:255',
            'email'           => 'required|email|unique:m_user,email|max:255',
            'phone_number'    => 'required|string|max:20',
            'password'        => 'required|string|min:6',
            'confirmPassword' => 'required|same:password', // Memastikan sama dengan password
            'role'            => 'required|in:member,team_leader', // Mencegah user inspect element & ubah value

            // Validasi Team Profile (HANYA wajib jika role == 'team_leader')
            'team_name'         => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string|max:255',
            'team_phone_number' => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string|max:20',
            'team_email'        => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|email|max:255',
            'team_join_date'    => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|date',
            'team_founded_year' => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|numeric|min:1900|max:2099',
            'team_state'        => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string|max:255',
            'team_type_id'      => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string',
            'team_province_id'  => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string',
            'team_city_id'      => 'required_if:role,725c2c76-31c1-11f1-8cba-a036bc3bed8f|nullable|string',
            'team_image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Opsional, maks 2MB
        ], [
            // Custom Error Message
            'confirmPassword.same' => 'The password confirmation does not match.',
            'email.unique' => 'This email address is already registered.',
        ]);

        // 2. Mulai Database Transaction 
        // (Agar jika gagal insert Team, insert User dibatalkan secara otomatis)
        DB::beginTransaction();

        try {
            // 3. Buat Data User
            $user = User::create([
                'full_name' => $request->fullName, // Sesuaikan dengan nama kolom DB Anda (misal: 'name' atau 'full_name')
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'user_type_id' => $request->role,
                'created_by' => "Super Admin",
                'modified_by' => "Super Admin",
            ]);

            // 4. Cek Jika Dia Mendaftar Sebagai Team Leader
            if ($request->role === '725c2c76-31c1-11f1-8cba-a036bc3bed8f') {
                $imagePath = null;

                // Proses Upload Logo Tim
                if ($request->hasFile('team_image')) {
                    $imagePath = $request->file('team_image')->store('teams', 'public');
                }

                // Buat Data Tim & Relasikan dengan User tersebut
                Team::create([
                    'user_id' => $user->id, // Mengaitkan tim ini dengan user yang baru dibuat
                    'name' => $request->team_name,
                    'phone_number' => $request->team_phone_number,
                    'email' => $request->team_email,
                    'join_date' => $request->team_join_date,
                    'founded_year' => $request->team_founded_year,
                    'state' => $request->team_state,
                    'type_id' => $request->team_type_id,
                    'province_id' => $request->team_province_id,
                    'city_id' => $request->team_city_id,
                    'image' => $imagePath,
                    'created_by' => $user->id,
                    'modified_by' => $user->id,
                ]);
            }

            // 5. Simpan permanen ke database
            DB::commit();

            // 6. (Opsional) Langsung login-kan user setelah mendaftar
            Auth::login($user);

            // 7. Redirect ke Dashboard dengan pesan sukses
            return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Welcome to LayApp.');
        } catch (\Exception $e) {
            // Jika ada error (Database / Upload), batalkan semua insert
            DB::rollBack();

            // Log Error agar mudah di-debug
            Log::error('Registration Error: ' . $e->getMessage());

            // Kembalikan ke halaman form beserta error
            return back()->withInput()->withErrors([
                'error' => 'Something went wrong during registration. Please try again. System: ' . $e->getMessage()
            ]);
        }
    }
}
