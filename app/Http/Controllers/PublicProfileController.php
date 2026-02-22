<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'location' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'public_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'is_public' => ['boolean'],
        ]);

        $request->user()->profile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return redirect()->route('public-profile.edit')
            ->with('status', 'profile-updated');
    }
}
