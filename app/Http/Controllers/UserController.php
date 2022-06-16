<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'Store Owner')->paginate(10);
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        return view('users.view', ['user' => $user]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Supervisor'],
            'status' => ['required']
        ]);
        $request['password'] = Hash::make($request->password);
        User::create($request->all());
        return redirect('/users');
    }

    public function edit(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required'],
            'status' => ['required']
        ]);
        $user->update($request->all());
        return redirect('/users');
    }

    public function destroy(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        if (!($user->offers->count() || $user->store->count() || $user->reviewedOffers->count()))
            $user->delete();
        return redirect('/users');
    }

    public function changePassword()
    {
        return view('auth.passwords.change');
    }

    public function changePasswordStore(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with('success', __('Password has changed successfuly.'));
    }

    public function changeStatus(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        $user->update(['status' => !$user->status]);
        return back();
    }
}
