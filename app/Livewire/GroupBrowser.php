<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Group;

#[Layout('layouts.dashboard', ['title' => 'Groups Directory'])]
class GroupBrowser extends Component
{
    use WithPagination;

    public string $search = '';
    public string $country = '';
    public string $state = '';
    public string $city = '';

    // Reset pagination whenever any filter changes
    public function updating(string $field): void
    {
        if (in_array($field, ['search', 'country', 'state', 'city'])) {
            $this->resetPage();
        }
    }

    // Cascade: changing country resets state and city
    public function updatedCountry(): void
    {
        $this->state = '';
        $this->city = '';
    }

    // Cascade: changing state resets city
    public function updatedState(): void
    {
        $this->city = '';
    }

    public function render()
    {
        // --- Main Group Query ---
        $query = Group::with('user.profile')
            ->where('is_public', true);

        // Text search: name, tradition, or description
        if (!empty($this->search)) {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('tradition', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        if (!empty($this->country)) {
            $query->where('country', $this->country);
        }
        if (!empty($this->state)) {
            $query->where('state_province', $this->state);
        }
        if (!empty($this->city)) {
            $query->where('city', 'like', '%' . $this->city . '%');
        }

        $query->orderBy('name', 'asc');

        $groups = $query->paginate(24);

        // --- Extracted Filter Lists (for the UI) ---
        // Get all public groups to build distinct location lists
        $allPublicGroups = Group::where('is_public', true)->get();

        $countries = $allPublicGroups->pluck('country')->filter()->unique()->sort()->values()->toArray();

        // Based on selected country (if any), get the available states
        $states = [];
        if (!empty($this->country)) {
            $states = $allPublicGroups->where('country', $this->country)
                ->pluck('state_province')
                ->filter()
                ->unique()
                ->sort()
                ->values()
                ->toArray();
        }

        return view('livewire.group-browser', [
            'groups' => $groups,
            'countries' => collect($countries)->mapWithKeys(function ($code) {
                $countryNames = [
                    'US' => 'United States',
                    'GB' => 'United Kingdom',
                    'CA' => 'Canada',
                    'AU' => 'Australia',
                    'IE' => 'Ireland',
                    'NZ' => 'New Zealand',
                ];
                return [$code => $countryNames[$code] ?? $code];
            })->toArray(),
            'states' => $states,
        ]);
    }
}
