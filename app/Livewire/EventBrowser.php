<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Event;
use Carbon\Carbon;

#[Layout('layouts.dashboard', ['title' => 'Browse Events'])]
class EventBrowser extends Component
{
    use WithPagination;

    public string $search = '';
    public string $country = '';
    public string $state = '';
    public string $city = '';
    public string $dateFilter = ''; // '', 'this_month', 'upcoming'

    // Reset pagination on any filter change
    public function updating(string $field): void
    {
        if (in_array($field, ['search', 'country', 'state', 'city', 'dateFilter'])) {
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
        // --- Main Event Query ---
        $query = Event::with('user.profile')
            ->where('is_public', true);

        // Text search: title, details, or organizer name
        if (!empty($this->search)) {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('details', 'like', "%{$term}%")
                    ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$term}%"));
            });
        }

        // Geographic filters
        if (!empty($this->country)) {
            $query->where('country', $this->country);
        }
        if (!empty($this->state)) {
            $query->where('state_province', $this->state);
        }
        if (!empty($this->city)) {
            $query->where('city', $this->city);
        }

        // Date quick-filters
        if ($this->dateFilter === 'this_month') {
            $query->whereBetween('start_date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ]);
        } elseif ($this->dateFilter === 'upcoming') {
            $query->where('start_date', '>=', Carbon::today());
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(24);

        // --- Filter Dropdown Data ---
        $basePublic = Event::where('is_public', true);

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
            if (!empty($this->country)) {
                $citiesQuery->where('country', $this->country);
            }
            $availableCities = $citiesQuery->pluck('city');
        }

        // Country code → full name map
        $countryNames = [
            'US' => 'United States',
            'CA' => 'Canada',
        ];

        // Dynamic state label
        $stateLabel = match ($this->country) {
            'US' => 'State',
            'CA' => 'Province',
            default => 'State / Province',
        };

        return view('livewire.event-browser', [
            'events' => $events,
            'availableCountries' => $availableCountries,
            'availableStates' => $availableStates,
            'availableCities' => $availableCities,
            'countryNames' => $countryNames,
            'stateLabel' => $stateLabel,
        ]);
    }
}
