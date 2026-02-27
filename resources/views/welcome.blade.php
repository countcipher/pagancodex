@extends('layouts.dashboard')

@section('title', 'The Community Directory')

@section('content')

    <div class="home-container">

        <section class="hero-panel" aria-labelledby="hero-title">
            <h1 id="hero-title" class="hero-panel__title">The Wheel is Turning. Connect with Your Community.</h1>
            <p class="hero-panel__subtitle">Pagan Codex is a directory and resource hub helping Witches, Pagans, and magical
                practitioners find each other, local events, and trusted merchants.</p>

            <div class="hero-panel__stats">
                <div class="stat-block">
                    <span class="stat-block__value">{{ $stats['users'] ?? 0 }}</span>
                    <span class="stat-block__label">Members</span>
                </div>
                <div class="stat-block">
                    <span class="stat-block__value">{{ $stats['groups'] ?? 0 }}</span>
                    <span class="stat-block__label">Covens & Groups</span>
                </div>
                <div class="stat-block">
                    <span class="stat-block__value">{{ $stats['events'] ?? 0 }}</span>
                    <span class="stat-block__label">Public Events</span>
                </div>
                <div class="stat-block">
                    <span class="stat-block__value">{{ $stats['shops'] ?? 0 }}</span>
                    <span class="stat-block__label">Local Shops</span>
                </div>
            </div>

            @guest
                <div class="hero-panel__actions">
                    <a href="{{ route('register') }}" class="btn btn--primary hero-panel__btn">Join the Directory</a>
                    <a href="{{ route('login') }}" class="btn btn--secondary hero-panel__btn" style="margin-left: 0.5rem;">Log
                        In</a>
                </div>
            @endguest
        </section>

        <!-- Upcoming Events Section -->
        <section class="home-section-card" aria-labelledby="events-title">
            <header class="home-section-header">
                <h2 id="events-title" class="home-section-header__title">Upcoming Gatherings</h2>
                <a href="{{ route('events.browse') }}" class="home-section-header__link">View All Events &rarr;</a>
            </header>

            @if($upcomingEvents->isEmpty())
                <div class="home-empty">
                    <p>The wheel is always turning, but no events are scheduled right now. Be the first to host one!</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($upcomingEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="home-item-card">
                            <h3 class="home-item-card__title">{{ $event->title }}</h3>
                            <div class="home-item-card__meta">
                                <x-heroicon-o-calendar class="home-item-card__meta-icon" />
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y - g:i A') }}
                            </div>
                            <div class="home-item-card__meta">
                                <x-heroicon-o-map-pin class="home-item-card__meta-icon" />
                                {{ $event->city }}, {{ $event->state_province }}
                            </div>
                            @if($event->details)
                                <p class="home-item-card__desc">{{ Str::limit($event->details, 120) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Discover Local Communities (Groups) Section -->
        <section class="home-section-card" aria-labelledby="groups-title">
            <header class="home-section-header">
                <h2 id="groups-title" class="home-section-header__title">Discover Local Communities</h2>
                <a href="{{ route('groups.browse') }}" class="home-section-header__link">View Directory &rarr;</a>
            </header>

            @if($discoverGroups->isEmpty())
                <div class="home-empty">
                    <p>Looking for your people? Our directory is just starting out. Start a group to help others find you.</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($discoverGroups as $group)
                        <a href="{{ route('groups.show', $group) }}" class="home-item-card">
                            <h3 class="home-item-card__title">{{ $group->name }}</h3>
                            <div class="home-item-card__meta home-item-card__meta--highlight">
                                {{ $group->tradition ?? 'Eclectic / All Paths Welcome' }}
                            </div>
                            <div class="home-item-card__meta">
                                <x-heroicon-o-map-pin class="home-item-card__meta-icon" />
                                {{ collect([$group->city, $group->state_province])->filter()->join(', ') ?: 'Online / Undisclosed' }}
                            </div>
                            @if($group->description)
                                <p class="home-item-card__desc">{{ Str::limit($group->description, 120) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Featured Merchants Section -->
        <section class="home-section-card" aria-labelledby="shops-title">
            <header class="home-section-header">
                <h2 id="shops-title" class="home-section-header__title">Featured Merchants & Shops</h2>
                <a href="{{ route('shops.browse') }}" class="home-section-header__link">Explore All Shops &rarr;</a>
            </header>

            @if($featuredShops->isEmpty())
                <div class="home-empty">
                    <p>Support your local esoteric community. Add your shop to our growing directory.</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($featuredShops as $shop)
                        <a href="{{ route('shops.browse') }}" class="home-item-card">
                            <h3 class="home-item-card__title">{{ $shop->name }}</h3>
                            <div class="home-item-card__meta">
                                <x-heroicon-o-map-pin class="home-item-card__meta-icon" />
                                {{ $shop->city }}, {{ $shop->state_province }}
                            </div>
                            @if($shop->description)
                                <p class="home-item-card__desc">{{ Str::limit($shop->description, 120) }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- New Faces Section -->
        @if($newProfiles->isNotEmpty())
            <section class="home-section-card home-section-card--last" aria-labelledby="profiles-title">
                <header class="home-section-header">
                    <h2 id="profiles-title" class="home-section-header__title">New Faces in the Directory</h2>
                    <a href="{{ route('directory') }}" class="home-section-header__link">View Directory &rarr;</a>
                </header>

                <div class="faces-grid">
                    @foreach($newProfiles as $profile)
                        <a href="{{ route('practitioners.show', $profile) }}" class="face-card">
                            <img src="{{ $profile->avatar_path ? Storage::url($profile->avatar_path) : '/images/default-avatar.png' }}"
                                alt="{{ $profile->user->name }}'s Avatar" class="face-avatar" loading="lazy">
                            <div class="face-name">{{ explode(' ', trim($profile->user->name))[0] }}</div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
@endsection