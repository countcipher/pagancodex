<div class="directory-wrapper" wire:loading.class="opacity-50">

    {{-- ===== Filter Sidebar ===== --}}
    <aside class="directory-filters">
        <p class="directory-filters__title">Filter</p>

        {{-- Text Search --}}
        <div class="directory-filters__group">
            <label for="dir-search" class="directory-filters__label">Search</label>
            <input id="dir-search" type="search" wire:model.live.debounce.350ms="search"
                class="directory-filters__input" placeholder="Name, tradition…">
        </div>

        {{-- Country --}}
        <div class="directory-filters__group">
            <label for="dir-country" class="directory-filters__label">Country</label>
            <select id="dir-country" wire:model.live="country" class="directory-filters__select">
                <option value="">All Countries</option>
                @foreach($availableCountries as $code)
                    <option value="{{ $code }}">{{ $countryNames[$code] ?? $code }}</option>
                @endforeach
            </select>
        </div>

        {{-- State / Province (label changes based on selected country) --}}
        <div class="directory-filters__group">
            <label for="dir-state" class="directory-filters__label">{{ $stateLabel }}</label>
            <select id="dir-state" wire:model.live="state" class="directory-filters__select" {{ empty($country) ? 'disabled' : '' }}>
                <option value="">All {{ $stateLabel }}s</option>
                @foreach($availableStates as $s)
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

        {{-- City --}}
        <div class="directory-filters__group">
            <label for="dir-city" class="directory-filters__label">City</label>
            <select id="dir-city" wire:model.live="city" class="directory-filters__select" {{ empty($state) ? 'disabled' : '' }}>
                <option value="">All Cities</option>
                @foreach($availableCities as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        {{-- Clergy Filter --}}
        <div class="directory-filters__group directory-filters__group--toggle">
            <label class="directory-toggle">
                <input type="checkbox" wire:model.live="clergyOnly" class="directory-toggle__input">
                <span class="directory-toggle__switch"></span>
                <span class="directory-toggle__label">Show Clergy Only</span>
            </label>
        </div>

        {{-- Reset Filters --}}
        @if($search || $country || $state || $city || $clergyOnly)
            <button
                wire:click="$set('search', ''); $set('country', ''); $set('state', ''); $set('city', ''); $set('clergyOnly', false);"
                class="directory-filters__reset">
                Clear Filters
            </button>
        @endif
    </aside>

    {{-- ===== Results Area ===== --}}
    <section class="directory-results" aria-live="polite" aria-label="Directory results">

        <header class="directory-results__header">
            <h2 class="directory-results__title">Members</h2>
            <span class="directory-results__count">{{ $profiles->total() }}
                {{ Str::plural('result', $profiles->total()) }}</span>
        </header>

        @if($profiles->isEmpty())
            <div class="directory-empty">
                <p>No members found matching your filters. Try broadening your search!</p>
            </div>
        @else
            <div class="profile-grid">
                @foreach($profiles as $profile)
                    <a href="{{ route('practitioners.show', $profile) }}" class="profile-card"
                        aria-label="View {{ $profile->user->name }}'s profile">

                        @if($profile->avatar_path)
                            <img src="{{ Storage::url($profile->avatar_path) }}" alt="{{ $profile->user->name }}'s avatar"
                                class="profile-card__avatar" loading="lazy">
                        @else
                            <img src="/images/default-avatar.png" alt="Default avatar" class="profile-card__avatar">
                        @endif

                        <div class="profile-card__name">
                            {{ $profile->user->name }}
                            @if($profile->clergy)
                                <span class="profile-card__clergy-badge" title="Registered Clergy">
                                    <x-heroicon-s-sparkles class="profile-card__clergy-icon" />
                                </span>
                            @endif
                        </div>

                        @if($profile->tradition)
                            <div class="profile-card__tradition">{{ $profile->tradition }}</div>
                        @endif

                        @php
                            $location = collect([$profile->city, $profile->state_province])->filter()->join(', ');
                        @endphp
                        @if($location)
                            <div class="profile-card__location">
                                <x-heroicon-o-map-pin class="profile-card__icon" />
                                {{ $location }}
                            </div>
                        @endif

                    </a>
                @endforeach
            </div>

            <div class="directory-pagination">
                {{ $profiles->links() }}
            </div>
        @endif

    </section>

</div>
</div>