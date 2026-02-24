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
}
