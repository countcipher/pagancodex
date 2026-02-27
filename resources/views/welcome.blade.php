@extends('layouts.dashboard')

@section('title', 'The Community Directory')

@push('head')
    <style>
        /* Homepage Specific Adjustments to build on Dashboard base */

        .home-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Hero Panel */
        .hero-panel {
            background-color: var(--color-panel-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            padding: 4rem 2rem;
            text-align: center;
            margin-bottom: 3rem;
            box-shadow: var(--shadow-sm);
        }

        .hero-panel__title {
            font-family: var(--font-heading);
            font-size: 2.5rem;
            color: var(--color-primary);
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero-panel__subtitle {
            font-size: 1.125rem;
            color: var(--color-text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .hero-panel__stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .stat-block {
            text-align: center;
        }

        .stat-block__value {
            display: block;
            font-family: var(--font-heading);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-primary);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-block__label {
            font-size: 0.875rem;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        /* Section Layouts */
        .home-section {
            margin-bottom: 4rem;
        }

        .home-section__header {
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--color-brand-tan);
            padding-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .home-section__title {
            font-family: var(--font-heading);
            font-size: 1.75rem;
            color: var(--color-primary);
            margin: 0;
        }

        .home-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        /* Entity Cards (Extending Dashboard aesthetics) */
        .entity-card {
            background-color: var(--color-panel-bg);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s;
            box-shadow: 0 1px 3px rgba(42, 26, 8, 0.05);
        }

        .entity-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--color-primary);
        }

        .entity-card__title {
            font-family: var(--font-heading);
            font-size: 1.25rem;
            color: var(--color-primary);
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }

        .entity-card__meta {
            font-size: 0.875rem;
            color: var(--color-text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .entity-card__meta-icon {
            color: var(--color-primary);
            width: 1rem;
            height: 1rem;
        }

        .entity-card__desc {
            font-size: 0.95rem;
            color: var(--color-text);
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-top: auto;
            border-top: 1px dashed var(--color-border);
            padding-top: 1rem;
        }

        /* New Faces Grid */
        .faces-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: flex-start;
        }

        .face-card {
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s;
        }

        .face-card:hover {
            transform: scale(1.05);
        }

        .face-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--color-panel-bg);
            box-shadow: 0 0 0 1px var(--color-border);
            margin-bottom: 0.75rem;
        }

        .face-name {
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--color-primary);
        }

        /* Empty States */
        .home-empty {
            background-color: var(--color-panel-bg);
            border: 1px dashed var(--color-border);
            border-radius: var(--radius-md);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--color-text-muted);
        }

        @media (max-width: 768px) {
            .hero-panel {
                padding: 3rem 1.5rem;
            }

            .hero-panel__title {
                font-size: 2rem;
            }

            .hero-panel__stats {
                gap: 1.5rem;
            }

            .home-container {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')

    <div class="home-container">

        <section class="hero-panel" aria-labelledby="hero-title">
            <h1 id="hero-title" class="hero-panel__title">The Wheel is Turning. Connect with Your Community.</h1>
            <p class="hero-panel__subtitle">Pagan Codex is a directory and resource hub helping Witches, Pagans, and magical
                practitioners find each other, local events, and trusted merchants.</p>

            <div class="hero-panel__stats">
                <div class="stat-block">
                    <span class="stat-block__value">{{ $stats['users'] ?? 0 }}</span>
                    <span class="stat-block__label">Practitioners</span>
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
                <div style="margin-top: 2rem;">
                    <a href="{{ route('register') }}" class="btn btn--primary"
                        style="font-size: 1.1rem; padding: 0.75rem 2rem;">Join the Directory</a>
                    <a href="{{ route('login') }}" class="btn btn--secondary"
                        style="font-size: 1.1rem; padding: 0.75rem 2rem; margin-left: 0.5rem;">Log In</a>
                </div>
            @endguest
        </section>

        <!-- Upcoming Events Section -->
        <section class="home-section" aria-labelledby="events-title">
            <header class="home-section__header">
                <h2 id="events-title" class="home-section__title">Upcoming Gatherings</h2>
            </header>

            @if($upcomingEvents->isEmpty())
                <div class="home-empty">
                    <p>The wheel is always turning, but no events are scheduled right now. Be the first to host one!</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($upcomingEvents as $event)
                        <article class="entity-card">
                            <h3 class="entity-card__title">{{ $event->title }}</h3>
                            <div class="entity-card__meta">
                                <x-heroicon-o-calendar class="entity-card__meta-icon" />
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y - g:i A') }}
                            </div>
                            <div class="entity-card__meta">
                                <x-heroicon-o-map-pin class="entity-card__meta-icon" />
                                {{ $event->city }}, {{ $event->state_province }}
                            </div>
                            <p class="entity-card__desc">{{ Str::limit($event->details, 120) }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Discover Local Communities (Groups) Section -->
        <section class="home-section" aria-labelledby="groups-title">
            <header class="home-section__header">
                <h2 id="groups-title" class="home-section__title">Discover Local Communities</h2>
            </header>

            @if($discoverGroups->isEmpty())
                <div class="home-empty">
                    <p>Looking for your people? Our directory is just starting out. Start a group to help others find you.</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($discoverGroups as $group)
                        <article class="entity-card">
                            <h3 class="entity-card__title">{{ $group->name }}</h3>
                            <div class="entity-card__meta" style="color: var(--color-primary); font-weight: 500;">
                                {{ $group->tradition ?? 'Eclectic / All Paths Welcome' }}
                            </div>
                            <div class="entity-card__meta">
                                <x-heroicon-o-map-pin class="entity-card__meta-icon" />
                                {{ collect([$group->city, $group->state_province])->filter()->join(', ') ?: 'Online / Undisclosed' }}
                            </div>
                            {{-- <p class="entity-card__desc">{{ Str::limit($group->description, 120) }}</p> --}}
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Featured Merchants Section -->
        <section class="home-section" aria-labelledby="shops-title">
            <header class="home-section__header">
                <h2 id="shops-title" class="home-section__title">Featured Merchants & Shops</h2>
            </header>

            @if($featuredShops->isEmpty())
                <div class="home-empty">
                    <p>Are you a creator or shop owner? List your business here for free to connect with the community.</p>
                </div>
            @else
                <div class="home-grid">
                    @foreach($featuredShops as $shop)
                        <article class="entity-card">
                            <h3 class="entity-card__title">{{ $shop->name }}</h3>
                            <div class="entity-card__meta">
                                <x-heroicon-o-map-pin class="entity-card__meta-icon" />
                                {{ collect([$shop->city, $shop->state_province])->filter()->join(', ') ?: 'Online Shop' }}
                            </div>
                            <p class="entity-card__desc">{{ Str::limit($shop->description, 120) }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- New Faces Section -->
        @if($newProfiles->isNotEmpty())
            <section class="home-section" aria-labelledby="profiles-title">
                <header class="home-section__header">
                    <h2 id="profiles-title" class="home-section__title">New Faces in the Directory</h2>
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