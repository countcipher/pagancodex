<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\Group;
use App\Models\Profile;
use App\Models\Shop;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Display the public homepage with dynamic directory data.
     */
    public function index(): \Illuminate\View\View
    {
        // 1. Total Counts for the Hero Section
        $stats = [
            'users' => User::count(),
            'events' => Event::where('is_public', true)->count(),
            'groups' => Group::where('is_public', true)->count(),
            'shops' => Shop::where('is_public', true)->count(),
        ];

        // 2. Upcoming Events (Next 3)
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->where('is_public', true)
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        // 3. Newest Local Communities (Groups)
        $discoverGroups = Group::where('is_public', true)
            ->latest()
            ->take(3)
            ->get();

        // 4. Featured Shops (3 Most Recent)
        $featuredShops = Shop::where('is_public', true)
            ->latest()
            ->take(3)
            ->get();

        // 5. New Faces (4 Recent Profiles with Avatars)
        $newProfiles = Profile::with('user')
            ->where('is_public', true)
            ->latest()
            ->take(9)
            ->get();

        return view('welcome', compact(
            'stats',
            'upcomingEvents',
            'discoverGroups',
            'featuredShops',
            'newProfiles'
        ));
    }
}
