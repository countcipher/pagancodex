<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the user's shops.
     */
    public function index(): \Illuminate\View\View
    {
        $shops = request()->user()->shops()->orderBy('name', 'asc')->paginate(20);

        return view('shops.index', [
            'shops' => $shops
        ]);
    }

    /**
     * Show the form for creating a new shop.
     */
    public function create(): \Illuminate\View\View
    {
        return view('shops.create');
    }

    /**
     * Store a newly created shop in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'],
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'is_public' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'hours_monday' => ['nullable', 'string', 'max:255'],
            'hours_tuesday' => ['nullable', 'string', 'max:255'],
            'hours_wednesday' => ['nullable', 'string', 'max:255'],
            'hours_thursday' => ['nullable', 'string', 'max:255'],
            'hours_friday' => ['nullable', 'string', 'max:255'],
            'hours_saturday' => ['nullable', 'string', 'max:255'],
            'hours_sunday' => ['nullable', 'string', 'max:255'],
        ]);

        // Clean up empty strings and ensure booleans are explicitly false if not present
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);
        $validated['is_public'] = $request->boolean('is_public');

        // Associate the shop with the logged in user
        $request->user()->shops()->create($validated);

        return redirect()->route('dashboard')
            ->with('status', 'shop-created');
    }

    /**
     * Show the form for editing the specified shop.
     */
    public function edit(Shop $shop): \Illuminate\View\View
    {
        // Security check: ensure the currently authenticated user actually owns this shop
        if ($shop->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('shops.edit', [
            'shop' => $shop
        ]);
    }

    /**
     * Update the specified shop in storage.
     */
    public function update(Request $request, Shop $shop): \Illuminate\Http\RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this shop
        if ($shop->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'country' => ['required', 'in:US,CA'],
            'state_province' => ['nullable', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'is_public' => ['boolean'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'hours_monday' => ['nullable', 'string', 'max:255'],
            'hours_tuesday' => ['nullable', 'string', 'max:255'],
            'hours_wednesday' => ['nullable', 'string', 'max:255'],
            'hours_thursday' => ['nullable', 'string', 'max:255'],
            'hours_friday' => ['nullable', 'string', 'max:255'],
            'hours_saturday' => ['nullable', 'string', 'max:255'],
            'hours_sunday' => ['nullable', 'string', 'max:255'],
        ]);

        // Clean up empty strings and ensure booleans are explicitly false if not present
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);
        $validated['is_public'] = $request->boolean('is_public');

        $shop->update($validated);

        return redirect()->route('shops.index')
            ->with('status', 'shop-updated');
    }

    /**
     * Remove the specified shop from storage.
     */
    public function destroy(Shop $shop): \Illuminate\Http\RedirectResponse
    {
        // Security check: ensure the currently authenticated user actually owns this shop
        if ($shop->user_id !== request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $shop->delete();

        return redirect()->route('shops.index')
            ->with('status', 'shop-deleted');
    }
}
