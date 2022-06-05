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
        $users = User::paginate(10);
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
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
            'role' => ['required'],
            'status' => ['required']
        ]);
        $request->password = Hash::make($request->password);
        User::create($request->all());
        return redirect('/users');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
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
        // return !json_encode($user->offers || $user->store || $user->reviewedOffers);
        if (!($user->offers || $user->store || $user->reviewedOffers))
            $user->delete();
        return redirect('/users');
    }
}
