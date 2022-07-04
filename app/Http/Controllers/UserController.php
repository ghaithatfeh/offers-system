<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
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

    public function store(UserRequest $request)
    {
        $user = new User($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/users');
    }

    public function edit(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect('/users');
    }

    public function destroy(User $user)
    {
        if ($user->role == 'Store Owner')
            return abort(404);
        if (!($user->offers->count() || $user->reviewedOffers->count()))
            $user->delete();
        return redirect('/users');
    }

    public function changePassword()
    {
        return view('auth.passwords.change');
    }

    public function changePasswordStore(PasswordRequest $request, User $user)
    {
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
