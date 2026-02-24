<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'], // We decided no "Don't Show Location" for events
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Clean up any empty strings sent by form
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);

        // Associate the event with the logged in user
        $request->user()->events()->create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'event-created');
    }

    /**
     * Display a listing of the user's events.
     */
    public function index(): View
    {
        $events = request()->user()->events()->orderBy('start_date', 'asc')->paginate(20);

        return view('events.index', [
            'events' => $events
        ]);
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(\App\Models\Event $event): View
    {
        // Security check: ensure the currently authenticated user actually owns this event
        if ($event->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('events.edit', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, \App\Models\Event $event): RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this event
        if ($event->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'], // We decided no "Don't Show Location" for events
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        // Clean up any empty strings sent by form
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('status', 'event-updated');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(\App\Models\Event $event): RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this event
        if ($event->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('status', 'event-deleted');
    }
}
