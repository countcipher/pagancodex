<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    /**
     * Display the public event detail page.
     */
    public function show(Event $event): View
    {
        // Security: only allow viewing public events
        if (!$event->is_public) {
            abort(404);
        }

        // Eager-load organizer and their profile for the avatar + member link
        $event->load('user.profile');

        $countryNames = [
            'US' => 'United States',
            'CA' => 'Canada',
        ];

        return view('events.show', [
            'event' => $event,
            'countryNames' => $countryNames,
        ]);
    }
}
