<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicProfileController extends Controller
{
    /**
     * Display the public profile edit form.
     */
    public function edit(Request $request): View
    {
        return view('public-profile.edit', [
            'user' => $request->user(),
            'profile' => $request->user()->profile,
        ]);
    }

    /**
     * Update the user's public profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tradition' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:255'],
            'state_province' => ['nullable', 'string', 'max:2'],
            'country' => ['nullable', 'in:US,CA'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'public_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'is_public' => ['boolean'],
            'clergy' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // Radio buttons submit '1' or '0' as strings; cast to boolean and default to false if missing
        $validated['clergy'] = (bool) ($validated['clergy'] ?? false);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $profile = $request->user()->profile;

            // Delete old avatar if one exists
            if ($profile?->avatar_path) {
                Storage::disk('public')->delete($profile->avatar_path);
            }

            $validated['avatar_path'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Remove the raw file key — only avatar_path is stored in the DB
        unset($validated['avatar']);

        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return redirect()->route('public-profile.edit')
            ->with('status', 'public-profile-updated');
    }
}
