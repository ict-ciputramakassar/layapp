<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserRolesController extends Controller
{
    /**
     * Display the user roles management page
     */
    public function index()
    {
        return view('views_backend.user-roles');
    }

    /**
     * Get all users with their roles (API endpoint)
     */
    public function getUsers()
    {
        $users = User::with('userType')->get(['id', 'full_name', 'email', 'phone_number', 'user_type_id']);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    /**
     * Get all available user types/roles
     */
    public function getRoles()
    {
        $roles = UserType::where('is_active', 1)->get(['id', 'code', 'name', 'permissions']);

        return response()->json([
            'success' => true,
            'data' => $roles,
        ]);
    }

    /**
     * Create a new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:m_user,email|max:255',
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|min:6',
            'user_type_id' => 'required|exists:m_user_type,id',
        ]);

        try {
            $currentUserId = Auth::id();

            $user = User::create([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'user_type_id' => $request->user_type_id,
                'is_active' => 1,
                'created_by' => $currentUserId,
                'modified_by' => $currentUserId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'data' => $user->load('userType'),
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, $userId)
    {
        $request->validate([
            'user_type_id' => 'required|exists:m_user_type,id',
        ]);

        try {
            $currentUserId = Auth::id();

            $user = User::findOrFail($userId);
            $user->update([
                'user_type_id' => $request->user_type_id,
                'modified_by' => $currentUserId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User role updated successfully!',
                'data' => $user->load('userType'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating user role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user role: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update user details (name, email, role)
     */
    public function updateUser(Request $request, $userId)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:m_user,email,' . $userId,
            'phone_number' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
            'user_type_id' => 'required|exists:m_user_type,id',
        ]);

        try {
            $currentUserId = Auth::id();

            $user = User::findOrFail($userId);
            $user->update([
                'full_name' => $request->full_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'user_type_id' => $request->user_type_id,
                'modified_by' => $currentUserId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'data' => $user->load('userType'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a user
     */
    public function deleteUser($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Prevent deleting the last super admin
            if ($user->userType->code === 'SA') {
                $superAdminCount = User::whereHas('userType', function ($query) {
                    $query->where('code', 'SA');
                })->count();

                if ($superAdminCount <= 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete the last super admin!',
                    ], 403);
                }
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:m_user_type,code',
            'permissions' => 'required|string|max:255',
        ]);

        try {
            $currentUserId = Auth::id();

            $role = UserType::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'permissions' => $request->permissions,
                'is_active' => 1,
                'created_by' => $currentUserId,
                'modified_by' => $currentUserId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully!',
                'data' => $role,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create role: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing role
     */
    public function updateRole(Request $request, $roleId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:3|unique:m_user_type,code,' . $roleId,
            'permissions' => 'required|string|max:255',
        ]);

        try {
            $currentUserId = Auth::id();

            $role = UserType::findOrFail($roleId);
            $role->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'permissions' => $request->permissions,
                'modified_by' => $currentUserId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully!',
                'data' => $role,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update role: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a role
     */
    public function deleteRole($roleId)
    {
        try {
            $role = UserType::findOrFail($roleId);

            // Prevent deleting if role has users assigned
            $userCount = User::where('user_type_id', $roleId)->count();
            if ($userCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete role that has users assigned!',
                ], 403);
            }

            // Prevent deleting built-in roles (optional)
            if (in_array($role->code, ['SA', 'A', 'TL', 'RF'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete built-in roles!',
                ], 403);
            }

            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully!',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete role: ' . $e->getMessage(),
            ], 500);
        }
    }
}
