<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Bulletin;

class BulletinController extends Controller
{
    /**
     * Display the authenticated user's bulletins (dashboard list).
     */
    public function index(): View
    {
        $bulletins = request()->user()->bulletins()->latest()->paginate(20);

        return view('bulletins.index', [
            'bulletins' => $bulletins,
        ]);
    }

    /**
     * Store a newly created bulletin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:200'],
            'link' => ['nullable', 'url', 'max:2000'],
        ]);

        // Clean up empty strings
        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);

        $request->user()->bulletins()->create($validated);

        return redirect()->route('bulletins.browse')
            ->with('status', 'bulletin-created');
    }

    /**
     * Show the form for editing the specified bulletin.
     */
    public function edit(Bulletin $bulletin): View
    {
        if ($bulletin->user_id != request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('bulletins.edit', [
            'bulletin' => $bulletin,
        ]);
    }

    /**
     * Update the specified bulletin in storage.
     */
    public function update(Request $request, Bulletin $bulletin): RedirectResponse
    {
        if ($bulletin->user_id != request()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:200'],
            'link' => ['nullable', 'url', 'max:2000'],
        ]);

        $validated = array_map(fn($v) => $v === '' ? null : $v, $validated);

        $bulletin->update($validated);

        return redirect()->route('bulletins.index')
            ->with('status', 'bulletin-updated');
    }

    /**
     * Remove the specified bulletin from storage.
     */
    public function destroy(Bulletin $bulletin): RedirectResponse
    {
        // Allow the owner OR an admin (role >= 10) to delete
        $user = request()->user();
        if ($bulletin->user_id != $user->id && $user->role < 10) {
            abort(403, 'Unauthorized action.');
        }

        $bulletin->delete();

        // If admin deleted from browse page, redirect back there
        if (url()->previous() !== route('bulletins.index')) {
            return redirect()->route('bulletins.browse')
                ->with('status', 'bulletin-deleted');
        }

        return redirect()->route('bulletins.index')
            ->with('status', 'bulletin-deleted');
    }
}
