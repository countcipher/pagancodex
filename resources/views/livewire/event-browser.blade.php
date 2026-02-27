<div class="directory-wrapper">

    {{-- ============================================================
    FILTER SIDEBAR
    ============================================================ --}}
    <aside class="directory-filters" aria-label="Event Filters">
        <h2 class="directory-filters__title">Filter Events</h2>

        {{-- Text Search --}}
        <div class="directory-filters__group">
            <label for="ev-search" class="directory-filters__label">Search</label>
            <input id="ev-search" type="search" wire:model.live.debounce.300ms="search"
                placeholder="Search events or organizers…" class="directory-filters__input">
        </div>

        {{-- Date Quick-Filter Pills --}}
        <div class="directory-filters__group">
            <span class="directory-filters__label">Date</span>
            <div class="date-filter-pills">
                <button wire:click="$set('dateFilter', '')"
                    class="date-pill {{ $dateFilter === '' ? 'date-pill--active' : '' }}">
                    All
                </button>
                <button wire:click="$set('dateFilter', 'upcoming')"
                    class="date-pill {{ $dateFilter === 'upcoming' ? 'date-pill--active' : '' }}">
                    All Upcoming
                </button>
                <button wire:click="$set('dateFilter', 'this_month')"
                    class="date-pill {{ $dateFilter === 'this_month' ? 'date-pill--active' : '' }}">
                    This Month
                </button>
            </div>
        </div>

        {{-- Country --}}
        <div class="directory-filters__group">
            <label for="ev-country" class="directory-filters__label">Country</label>
            <select id="ev-country" wire:model.live="country" class="directory-filters__select">
                <option value="">All Countries</option>
                @foreach($availableCountries as $code)
                    <option value="{{ $code }}">{{ $countryNames[$code] ?? $code }}</option>
                @endforeach
            </select>
        </div>

        {{-- State / Province (label changes based on country) --}}
        <div class="directory-filters__group">
            <label for="ev-state" class="directory-filters__label">{{ $stateLabel }}</label>
            <select id="ev-state" wire:model.live="state" class="directory-filters__select" {{ empty($country) ? 'disabled' : '' }}>
                <option value="">All {{ $stateLabel }}s</option>
                @foreach($availableStates as $s)
                    <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
            </select>
        </div>

        {{-- City --}}
        <div class="directory-filters__group">
            <label for="ev-city" class="directory-filters__label">City</label>
            <select id="ev-city" wire:model.live="city" class="directory-filters__select" {{ empty($state) ? 'disabled' : '' }}>
                <option value="">All Cities</option>
                @foreach($availableCities as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        {{-- Clear Filters --}}
        @if($search || $country || $state || $city || $dateFilter)
            <button
                wire:click="$set('search', ''); $set('country', ''); $set('state', ''); $set('city', ''); $set('dateFilter', '');"
                class="directory-filters__clear">
                ✕ Clear Filters
            </button>
        @endif
    </aside>

    {{-- ============================================================
    RESULTS AREA
    ============================================================ --}}
    <main class="directory-results" aria-live="polite">

        <header class="directory-results__header">
            <h2 class="directory-results__title">Events</h2>
            <span class="directory-results__count">{{ $events->total() }}
                {{ Str::plural('result', $events->total()) }}</span>
        </header>

        @if($events->isEmpty())
            <div class="directory-results__empty">
                <p>No events match your current filters.</p>
                <p>Try broadening your search or adjusting the date filter.</p>
            </div>
        @else
            <div class="event-grid">
                @foreach($events as $event)
                    <article class="event-card">

                        {{-- Date Badge --}}
                        <div class="event-card__date-band">
                            <span class="event-date">
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}
                                @if($event->end_date && $event->end_date !== $event->start_date)
                                    &ndash; {{ \Carbon\Carbon::parse($event->end_date)->format('M j, Y') }}
                                @endif
                            </span>
                        </div>

                        <div class="event-card__body">
                            {{-- Title --}}
                            <h3 class="event-card__title">{{ $event->title }}</h3>

                            {{-- Location --}}
                            <p class="event-card__location">
                                <span>
                                    {{ collect([$event->city, $event->state_province, $countryNames[$event->country] ?? $event->country])->filter()->join(', ') }}
                                </span>
                            </p>

                            {{-- Details (truncated to 120 chars) --}}
                            @if($event->details)
                                <p class="event-card__details">
                                    {{ Str::limit($event->details, 120) }}
                                </p>
                            @endif

                            {{-- Organizer --}}
                            <p class="event-card__organizer">
                                Hosted by
                                @if($event->user->profile && $event->user->profile->is_public)
                                    <a href="{{ route('practitioners.show', $event->user->profile) }}"
                                        class="event-card__organizer-link">{{ $event->user->name }}</a>
                                @else
                                    <span>{{ $event->user->name }}</span>
                                @endif
                            </p>
                        </div>

                    </article>
                @endforeach
            </div>

            <div class="directory-results__pagination">
                {{ $events->links() }}
            </div>
        @endif

    </main>

</div>