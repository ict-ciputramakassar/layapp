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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        return view("views_backend.signin");
    }

    public function authenticate(Request $request)
    {
        // Validate the login form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Check if user exists and is active
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            Log::warning("Login attempt with non-existent email: {$credentials['email']}");
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (!$user->is_active) {
            Log::warning("Login attempt with inactive user: {$credentials['email']}");
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            Log::info("User logged in successfully: {$credentials['email']}");
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            $routeLogin = match (Auth::user()->userType->code) {
                "SA" => "admin.dashboard",
                "TL" => "team_leader.team_members",
                default => "admin.signin",
            };

            return redirect()->route($routeLogin)->with('success', 'Login successful!');
        }

        // Authentication failed
        Log::warning("Failed login attempt for user: {$credentials['email']}");
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.signin');
    }

    public function signup()
    {
        $data = [
            "types" => TeamType::all(['id', 'name', 'code']),
            "cities" => City::where('is_active', 1)->get(['id', 'name', 'province_id']),
            "provinces" => Province::where('is_active', 1)->get(['id', 'name']),
            "roles" => UserType::whereNot('code', 'SA')->whereNot('code', 'A')->get(['id', 'name', 'code']),
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

            'role'            => 'required', // Cukup required saja, karena kita tahu itu ID dari DB
            'role_code'       => 'required', // Input tersembunyi dari Javascript

            // Validasi Team Profile (HANYA wajib jika role == 'team_leader')
            'team_name'         => 'required_if:role_code,TL|nullable|string|max:255',
            'team_phone_number' => 'required_if:role_code,TL|nullable|string|max:20',
            'team_email'        => 'required_if:role_code,TL|nullable|email|max:255',
            'team_join_date'    => 'required_if:role_code,TL|nullable|date',
            'team_founded_year' => 'required_if:role_code,TL|nullable|numeric|min:1900|max:2099',
            'team_state'        => 'required_if:role_code,TL|nullable|string|max:255',
            'team_type_id'      => 'required_if:role_code,TL|nullable|string',
            'team_province_id'  => 'required_if:role_code,TL|nullable|string',
            'team_city_id'      => 'required_if:role_code,TL|nullable|string',
            'team_address'      => 'required_if:role_code,TL|nullable|string',
            'team_image'        => 'required_if:role_code,TL|nullable|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
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
                'full_name' => $request->fullName,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'user_type_id' => $request->role,
                'created_by' => "Super Admin",
                'modified_by' => "Super Admin",
            ]);

            // 4. Cek Jika Dia Mendaftar Sebagai Team Leader
            if ($request->role_code === 'TL') {
                $imagePath = null;

                if ($request->hasFile('team_image')) {
                    $extension = $request->file('team_image')->getClientOriginalExtension();
                    $filename = Str::uuid() . '.' . $extension;
                    $request->file('team_image')->move(public_path('images/upload/teams/'), $filename);
                    $imagePath = 'images/upload/teams/' . $filename;
                }

                Team::create([
                    'user_id'      => $user->id,
                    'name'         => mb_convert_case($request->team_name, MB_CASE_TITLE, 'UTF-8'),
                    'address'      => $request->team_address,
                    'is_verified'  => 1,
                    'is_active'    => 1,
                    'phone_number' => $request->team_phone_number,
                    'email'        => $request->team_email,
                    'join_date'    => $request->team_join_date,
                    'founded_year' => $request->team_founded_year,
                    'state'        => $request->team_state,
                    'type_id'      => $request->team_type_id,
                    'province_id'  => $request->team_province_id,
                    'city_id'      => $request->team_city_id,
                    'team_type_id' => $request->team_type_id,
                    'image'        => $imagePath,
                    'created_by'   => $user->id,
                    'modified_by'  => $user->id,
                ]);
            }

            // 5. Simpan permanen ke database
            DB::commit();

            // 6 Rerouting
            Auth::login($user, true);
            $routeLogin = match ($request->role_code) {
                "SA" => "admin.dashboard",
                "TL" => "team_leader.team_members",
                default => "admin.signin",
            };

            return redirect()->route($routeLogin)->with('success', 'Login successful!');
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
