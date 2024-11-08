<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function profile(string $link)
    {
        return Storage::download("profile_images/" . $link);
    }
    public function index(Request $request): Response
    {
        return Inertia::render('User/Index', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'users' => User::with('role')->get(),
            'roles' => Role::all(),
        ]);
    }


    public function create(Request $request): Response
    {
        return Inertia::render('User/Create', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'roles' => Role::all()
        ]);
    }
    public function edit(Request $request, User $user): Response
    {
        return Inertia::render('User/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'user' => $user,
            'roles' => Role::all()
        ]);
    }
    public function update(Request $request, User $user)
    {
        $validated = [];
        if ($request->password) {
            $user->update(["password" =>  Hash::make($request->password)]);
        }
        if (isset($request->email) && $request->email !== $user->email) {
            $validated['email'] = $request->validate([
                'email' => 'required|email|unique:users,email'
            ]);
            $user->update($validated['email']);
        }
        if (isset($request->name) && $request->name !== $user->name) {
            $validated["name"] = $request->validate([
                'name' => 'required|string|max:255'
            ]);
            $user->update($validated['name']);
        }
        if (isset($request->phone) && $request->phone !== $user->phone) {
            $validated["phone"] = $request->validate([
                'phone' => 'required|regex:/^[6-9]\d{9}$/',
            ]);
            $user->update($validated['phone']);
        }
        if (isset($request->description) && $request->description !== $user->description) {
            $validated["description"] = $request->validate([
                'description' => 'nullable|string',
            ]);
            $user->update($validated['description']);
        }
        if (isset($request->role_id) && $request->role_id !== $user->role_id) {
            $validated["role_id"] = $request->validate([
                'role_id' => 'required|integer|exists:roles,id'
            ]);
            $user->update($validated['role_id']);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images');
            $validated["profile_image"] = $path;
            $user->update(["profile_image" => $path]);
        }

        return redirect()->route('user.index');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[6-9]\d{9}$/',
            'description' => 'nullable|string',
            'role_id' => 'required|integer|exists:roles,id',
            'profile_image' => 'required|image|mimes:jpg,jpeg,svg,png|max:2048',
        ]);
        $validated['phone'] = "+91" . $validated['phone'];
        $validated["password"] = Hash::make($validated['password']);
        $user = new User($validated);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images');
            $user->profile_image = $path;
        }
        $user->save();


        return redirect()->route('user.index');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back();
    }
}
