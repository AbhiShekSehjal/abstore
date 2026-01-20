<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        // Get search query and sort option
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'name_asc');
        
        // Build the query
        $query = User::query();
        
        // Apply search filter
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        }
        
        // Apply sorting
        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'email_asc':
                $query->orderBy('email', 'asc');
                break;
            case 'email_desc':
                $query->orderBy('email', 'desc');
                break;
            case 'role_asc':
                $query->orderBy('role', 'asc');
                break;
            case 'role_desc':
                $query->orderBy('role', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default: // name_asc
                $query->orderBy('name', 'asc');
        }
        
        // Paginate with 10 users per page
        $users = $query->paginate(10);

        return view('admin.users', compact('users', 'search', 'sort'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($request->user_id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User deleted successfully');
    }
}
