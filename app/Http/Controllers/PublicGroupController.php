<?php

namespace App\Http\Controllers;

use App\Models\Group;

class PublicGroupController extends Controller
{
    /**
     * Display the specified public group.
     */
    public function show(Group $group)
    {
        // Only allow viewing if the group is public
        if (!$group->is_public) {
            abort(404);
        }

        // Eager load the user who listed the group along with their profile
        // so we can display their avatar and name without N+1 query issues.
        $group->load('user.profile');

        return view('groups.show', compact('group'));
    }
}
