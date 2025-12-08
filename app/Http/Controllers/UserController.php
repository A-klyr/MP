<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->name, function ($query, $name) {
                return $query->where('name', 'like', '%'.$name.'%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        // validasi sederhana
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'User successfully created');
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        // bila password diisi, update. Jika tidak, abaikan
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }
}
