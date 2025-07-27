<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validate input
        $request->validate([
            'phone_no' => ['required', 'string', 'min:11', 'max:15'],
            'bvn' => ['required', 'string', 'min:11', 'max:20'],
            'nin' => ['required', 'string', 'min:11', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Check if profile already activated
        $alreadyActivated = $user->bvn && $user->nin && $user->phone_no && $user->address;

        if ($alreadyActivated) {
            return Redirect::route('profile.edit')->with('error', 'Profile is already activated. Contact support.');
        }

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            // Delete old image if exists
            if ($user->profile_photo_url && Storage::disk('public')->exists($user->profile_photo_url)) {
                Storage::disk('public')->delete($user->profile_photo_url);
            }

            $file = $request->file('photo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store the image in storage/app/public/profile_photos
            $path = $file->storeAs('profile_photos', $filename, 'public');

            // Save only the relative path, not full URL
            $user->profile_photo_url = $path;
            $user->photo = $filename;
        }

        // Fill other fields (excluding file)
        $user->fill($request->except('photo'));

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

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
}
