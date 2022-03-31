<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // USER MANAGEMENT
    public function index()
    {
        $roles = Role::all();
        return view('cms.users', compact('roles'));
    }

    public function store()
    {
        $attr = request()->validate([
            'name' => 'required',
            'department' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|exists:roles,id',
            'password' => 'required|min:6',
        ]);

        User::create(array_merge($attr, [
            'role_id' => request('role'),
            'password' => bcrypt(request('password'))
        ]));

        return response()->json(['success' => 'User Successfully Created!'], 200);
    }

    public function update(User $user)
    {
        $attr = request()->validate([
            'name' => 'required',
            'department' => 'required',
            'email' => ['required', 'email', 'unique:users,id,' . $user->id],
            'role' => 'required|exists:roles,id',
        ]);

        $user->update([
            'name' => request('name'),
            'department' => request('department'),
            'email' => request('email'),
            'role_id' => request('role'),
        ]);

        return response()->json(['success' => 'User Successfully Updated!'], 200);
    }

    public function destroy(User $user)
    {
        request()->validate([
            'password' => 'required'
        ]);

        if (!Hash::check(request('password'), auth()->user()->password)) {
            // replicates the laravel's validation json response.
            return response()->json(['errors' => [
                'password' => ['Invalid Password!']
            ]], 422);
        }

        $user->delete();

        return response()->json(['success' => 'User Successfully Deleted!'], 200);
    }

    public function records()
    {
        $query = User::with('role');

        return JsonResource::collection($query->paginate(request('per_page')));
    }
}
