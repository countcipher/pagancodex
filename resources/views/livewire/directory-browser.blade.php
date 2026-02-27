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
                    <option value="{{ $s }}">{{ $s }}</option>
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

        {{-- Reset Filters --}}
        @if($search || $country || $state || $city)
            <button wire:click="$set('search', ''); $set('country', ''); $set('state', ''); $set('city', '');"
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

                        <div class="profile-card__name">{{ $profile->user->name }}</div>

                        @if($profile->tradition)
                            <div class="profile-card__tradition">{{ $profile->tradition }}</div>
                        @endif

                        @php
                            $location = collect([$profile->city, $profile->state_province])->filter()->join(', ');
                        @endphp
                        @if($location)
                            <div class="profile-card__location">
                                <x-heroicon-o-map-pin style="width:0.85rem;height:0.85rem;" />
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