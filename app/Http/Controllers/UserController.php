<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\SystemLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('outlet')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $outlets = Outlet::where('is_active', true)->get();
        return view('users.create', compact('outlets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:admin,kasir,owner',
            'outlet_id' => 'nullable|exists:outlets,id',
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        SystemLog::record('create', "User '{$user->name}' ({$user->role}) ditambahkan.", 'User', $user->id);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $outlets = Outlet::where('is_active', true)->get();
        return view('users.edit', compact('user', 'outlets'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|in:admin,kasir,owner',
            'outlet_id' => 'nullable|exists:outlets,id',
            'is_active' => 'boolean',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        SystemLog::record('update', "User '{$user->name}' diperbarui.", 'User', $user->id);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $name = $user->name;
        $user->delete();
        SystemLog::record('delete', "User '{$name}' dihapus.", 'User', $user->id);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
