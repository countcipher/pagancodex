<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\View\View;

class PublicShopController extends Controller
{
    /**
     * Display the specified public shop.
     */
    public function show(Shop $shop): View
    {
        // Only allow viewing if the shop is public
        if (!$shop->is_public) {
            abort(404);
        }

        // Eager load the user who listed the shop along with their profile
        // so we can display their avatar and name without N+1 query issues.
        $shop->load('user.profile');

        return view('shops.show', compact('shop'));
    }
}
