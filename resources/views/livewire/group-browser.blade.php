<div class="directory-wrapper" wire:loading.class="opacity-50">
    {{-- LEFT COLUMN: Filters --}}
    <aside class="directory-filters">
        <p class="directory-filters__title">Filter</p>

        <div class="directory-filters__group">
            <label for="search" class="directory-filters__label">Keywords</label>
            <input type="search" id="search" wire:model.live.debounce.300ms="search" class="directory-filters__input"
                placeholder="Search by name, tradition...">
        </div>

        <div class="directory-filters__group">
            <label for="country" class="directory-filters__label">Country</label>
            <select id="country" wire:model.live="country" wire:key="country-{{ empty($country) ? 'empty' : 'filled' }}"
                class="directory-filters__select">
                <option value="">All Countries</option>
                @foreach ($availableCountries as $code)
                    <option value="{{ $code }}">{{ $countryNames[$code] ?? $code }}</option>
                @endforeach
            </select>
        </div>

        <div class="directory-filters__group">
            <label for="state" class="directory-filters__label">{{ $stateLabel }}</label>
            <select id="dir-state" wire:model.live="state"
                wire:key="state-{{ empty($state) ? 'empty' : 'filled' }}-{{ $country }}"
                class="directory-filters__select" {{ empty($country) ? 'disabled' : '' }}>
                <option value="">All {{ $stateLabel }}s</option>
                @foreach ($availableStates as $s)
                    @php
                        $stateName = $s;
                        if ($country === 'US') {
                            $stateName = config('locations.states.' . $s) ?? $s;
                        } elseif ($country === 'CA') {
                            $stateName = config('locations.provinces.' . $s) ?? $s;
                        }
                    @endphp
                    <option value="{{ $s }}">{{ $stateName }}</option>
                @endforeach
            </select>
        </div>

        <div class="directory-filters__group">
            <label for="city" class="directory-filters__label">City</label>
            <select id="dir-city" wire:model.live="city"
                wire:key="city-{{ empty($city) ? 'empty' : 'filled' }}-{{ $state }}" class="directory-filters__select"
                {{ empty($state) ? 'disabled' : '' }}>
                <option value="">All Cities</option>
                @foreach ($availableCities as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        {{-- Clergy Filter --}}
        <div class="directory-filters__group directory-filters__group--toggle">
            <label class="directory-toggle">
                <input type="checkbox" wire:model.live="clergyOnly" wire:key="clergy-{{ $clergyOnly ? 'on' : 'off' }}"
                    class="directory-toggle__input">
                <span class="directory-toggle__switch"></span>
                <span class="directory-toggle__label">Show Clergy Only</span>
            </label>
        </div>

        {{-- Contact Info Filter --}}
        <div class="directory-filters__group directory-filters__group--toggle">
            <label class="directory-toggle">
                <input type="checkbox" wire:model.live="contactOnly"
                    wire:key="contact-{{ $contactOnly ? 'on' : 'off' }}" class="directory-toggle__input">
                <span class="directory-toggle__switch"></span>
                <span class="directory-toggle__label">Show Only With Contact Info</span>
            </label>
        </div>

        @if($search || $country || $state || $city || $clergyOnly || $contactOnly)
            <button wire:click="clearFilters" class="directory-filters__reset">
                Clear Filters
            </button>
        @endif
    </aside>

    <section class="directory-results" aria-live="polite" aria-label="Group results">

        <header class="directory-results__header">
            <h2 class="directory-results__title">Groups</h2>
            <span class="directory-results__count">{{ $groups->total() }}
                {{ Str::plural('result', $groups->total()) }}</span>
        </header>

        <div wire:loading.class="opacity-50" class="profile-grid">
            @forelse ($groups as $group)
                <a href="{{ route('groups.show', $group) }}" class="profile-card"
                    aria-label="View group: {{ $group->name }}">

                    <div class="profile-card__name">
                        {{ $group->name }}
                    </div>

                    @if($group->tradition)
                        <div class="profile-card__tradition">{{ $group->tradition }}</div>
                    @else
                        <div class="profile-card__tradition profile-card__tradition--empty">Eclectic / All Paths Welcome</div>
                    @endif

                    @php
                        $location = collect([$group->city, $group->state_province])->filter()->join(', ');
                    @endphp
                    @if($location)
                        <div class="profile-card__location">
                            <x-heroicon-o-map-pin class="profile-card__icon" />
                            {{ $location }}
                        </div>
                    @endif

                    @if($group->has_clergy)
                        <div class="profile-card__badge">
                            <span class="profile-card__badge--amber">★</span> Clergy Services Available
                        </div>
                    @endif
                </a>
            @empty
                <div class="directory-empty">
                    <p class="directory-empty__text">No groups found matching your criteria.</p>
                    <button wire:click="clearFilters" class="directory-empty__action">
                        Clear Filters
                    </button>
                </div>
            @endforelse
        </div>

        <div class="directory-pagination">
            {{ $groups->links() }}
        </div>

    </section>
</div>