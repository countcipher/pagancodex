<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Show the form for creating a new group.
     */
    public function create(): \Illuminate\View\View
    {
        return view('groups.create');
    }

    /**
     * Store a newly created group in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tradition' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'],
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'has_clergy' => ['boolean'],
            'is_public' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
        ]);

        // Clean up empty strings and ensure booleans are explicitly false if not present
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);
        $validated['has_clergy'] = $request->boolean('has_clergy');
        $validated['is_public'] = $request->boolean('is_public');

        // Associate the group with the logged in user
        $request->user()->groups()->create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'group-created');
    }

    /**
     * Display a listing of the user's groups.
     */
    public function index(): \Illuminate\View\View
    {
        $groups = request()->user()->groups()->orderBy('name', 'asc')->paginate(20);

        return view('groups.index', [
            'groups' => $groups
        ]);
    }

    /**
     * Show the form for editing the specified group.
     */
    public function edit(\App\Models\Group $group): \Illuminate\View\View
    {
        // Security check: ensure the currently authenticated user actually owns this group
        if ($group->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('groups.edit', [
            'group' => $group
        ]);
    }

    /**
     * Update the specified group in storage.
     */
    public function update(Request $request, \App\Models\Group $group): \Illuminate\Http\RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this group
        if ($group->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'tradition' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'],
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'has_clergy' => ['boolean'],
            'is_public' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
        ]);

        // Clean up empty strings and ensure booleans are explicitly false if not present
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);
        $validated['has_clergy'] = $request->boolean('has_clergy');
        $validated['is_public'] = $request->boolean('is_public');

        $group->update($validated);

        return redirect()->route('groups.index')
            ->with('status', 'group-updated');
    }

    /**
     * Remove the specified group from storage.
     */
    public function destroy(\App\Models\Group $group): \Illuminate\Http\RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this group
        if ($group->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $group->delete();

        return redirect()->route('groups.index')
            ->with('status', 'group-deleted');
    }
}
