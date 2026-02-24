<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Profile;

#[Layout('layouts.dashboard', ['title' => 'Public Directory'])]
class DirectoryBrowser extends Component
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
        // --- Main Profile Query ---
        $query = Profile::with('user')
            ->where('is_public', true);

        // Text search: user name, tradition, or bio
        if (!empty($this->search)) {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->whereHas('user', fn($uq) => $uq->where('name', 'like', "%{$term}%"))
                    ->orWhere('tradition', 'like', "%{$term}%")
                    ->orWhere('bio', 'like', "%{$term}%");
            });
        }

        // Geographic filters (applied in order)
        if (!empty($this->country)) {
            $query->where('country', $this->country);
        }
        if (!empty($this->state)) {
            $query->where('state_province', $this->state);
        }
        if (!empty($this->city)) {
            $query->where('city', $this->city);
        }

        $profiles = $query->latest()->paginate(12);

        // --- Filter Dropdown Data (only show what exists in DB) ---
        $basePublic = Profile::where('is_public', true);

        $availableCountries = (clone $basePublic)
            ->whereNotNull('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country');

        $availableStates = collect();
        if (!empty($this->country)) {
            $availableStates = (clone $basePublic)
                ->where('country', $this->country)
                ->whereNotNull('state_province')
                ->distinct()
                ->orderBy('state_province')
                ->pluck('state_province');
        }

        $availableCities = collect();
        if (!empty($this->state)) {
            $citiesQuery = (clone $basePublic)
                ->where('state_province', $this->state)
                ->whereNotNull('city')
                ->distinct()
                ->orderBy('city');

            // Also scope by country if one is selected
            if (!empty($this->country)) {
                $citiesQuery->where('country', $this->country);
            }

            $availableCities = $citiesQuery->pluck('city');
        }

        // --- State/Province Label ---
        // DB stores 'US' and 'CA' as country codes
        $stateLabel = match ($this->country) {
            'US' => 'State',
            'CA' => 'Province',
            default => 'State / Province',
        };

        // Map of country codes to full names for the dropdown display
        $countryNames = [
            'US' => 'United States',
            'CA' => 'Canada',
        ];

        return view('livewire.directory-browser', [
            'profiles' => $profiles,
            'availableCountries' => $availableCountries,
            'availableStates' => $availableStates,
            'availableCities' => $availableCities,
            'stateLabel' => $stateLabel,
            'countryNames' => $countryNames,
        ]);
    }
}
