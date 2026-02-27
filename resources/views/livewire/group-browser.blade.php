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
            <select id="country" wire:model.live="country" class="directory-filters__select">
                <option value="">All Countries</option>
                @foreach ($availableCountries as $code)
                    <option value="{{ $code }}">{{ $countryNames[$code] ?? $code }}</option>
                @endforeach
            </select>
        </div>

        <div class="directory-filters__group">
            <label for="state" class="directory-filters__label">{{ $stateLabel }}</label>
            <select id="state" wire:model.live="state" class="directory-filters__select" {{ empty($country) ? 'disabled' : '' }}>
                <option value="">All {{ $stateLabel }}s</option>
                @foreach ($availableStates as $s)
                    <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>
        </div>

        <div class="directory-filters__group">
            <label for="city" class="directory-filters__label">City</label>
            <select id="city" wire:model.live="city" class="directory-filters__select" {{ empty($state) ? 'disabled' : '' }}>
                <option value="">All Cities</option>
                @foreach ($availableCities as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        @if($search || $country || $state || $city)
            <button wire:click="$set('search', ''); $set('country', ''); $set('state', ''); $set('city', '');"
                class="directory-filters__reset">
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
                    <button wire:click="$set('search', ''); $set('country', ''); $set('state', ''); $set('city', '');"
                        class="directory-empty__action">
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