<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the change password request form.
     */
    public function showChangePasswordForm(Request $request): \Illuminate\View\View
    {
        return view('profile.change-password');
    }

    /**
     * Send password reset link to the specified email address.
     */
    public function sendChangePasswordLink(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = $request->user();
        
        // Generate password reset token for the authenticated user
        $token = \Illuminate\Support\Facades\Password::getRepository()->create($user);

        // Send the custom notification to the requested destination email
        \Illuminate\Support\Facades\Notification::route('mail', $request->email)
            ->notify(new \App\Notifications\CustomPasswordReset($token, $user->email));

        return back()->with('status', 'Tautan ganti kata sandi telah dikirim ke posel tujuan.');
    }
}

