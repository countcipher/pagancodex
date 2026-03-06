<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Bulletin;

#[Layout('layouts.dashboard', ['title' => 'Bulletin Board'])]
class BulletinBrowser extends Component
{
    use WithPagination;

    public function render()
    {
        $bulletins = Bulletin::with('user.profile')
            ->latest()
            ->paginate(20);

        return view('livewire.bulletin-browser', [
            'bulletins' => $bulletins,
        ]);
    }
}
