<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = Auth::user();
        return view('profile.show', ['user' => $user]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $userId = Auth::id();
        $user = User::find($userId);

        $user->name = $validate['name'];
        $user->phone = $validate['phone'];
        $user->address = $validate['address'];
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
