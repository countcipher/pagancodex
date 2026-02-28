@extends('layouts.dashboard')

@section('title', "{$shop->name} — Pagan Codex")

@section('content')
    <div class="directory-wrapper">
        <section class="profile-details-container">

            <div class="profile-header profile-header--flex">
                <div class="profile-header__title-group">
                    <h1 class="profile-header__name">{{ $shop->name }}</h1>

                    @php
                        $location = collect([$shop->city, $shop->state_province, $shop->country])->filter()->join(', ');
                    @endphp
                    @if($location)
                        <div class="profile-header__location">
                            <x-heroicon-o-map-pin class="icon" />
                            {{ $location }}
                        </div>
                    @endif
                </div>

                <a href="{{ route('shops.browse') }}" class="btn btn--secondary">
                    &larr; Back to Directory
                </a>
            </div>

            <div class="profile-card profile-card--full">

                <h2 class="profile-card__section-title">About the Shop</h2>
                <div class="profile-card__bio">
                    {!! nl2br(e($shop->description)) !!}
                </div>

                <h2 class="profile-card__section-title">Store Hours</h2>
                <div class="profile-card__contact-grid">
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        @if($shop->{"hours_{$day}"})
                            <div class="contact-item">
                                <span class="contact-item__label">{{ ucfirst($day) }}:</span>
                                <span class="contact-item__value">{{ $shop->{"hours_{$day}"} }}</span>
                            </div>
                        @endif
                    @endforeach

                    @if(collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])->every(fn($day) => empty($shop->{"hours_{$day}"})))
                        <p class="contact-item__value" style="grid-column: 1 / -1;">No hours listed.</p>
                    @endif
                </div>

                @if($shop->contact_email || $shop->phone_number || $shop->website || $shop->facebook_url || $shop->instagram_url || $shop->x_url)
                    <h2 class="profile-card__section-title mt-xl">Contact & Socials</h2>
                    <div class="profile-card__contact-grid">

                        @if($shop->website)
                            <div class="contact-item">
                                <span class="contact-item__label">Website:</span>
                                <a href="{{ $shop->website }}" target="_blank" rel="noopener noreferrer" class="contact-item__link">
                                    {{ str_replace(['http://', 'https://'], '', rtrim($shop->website, '/')) }}
                                </a>
                            </div>
                        @endif

                        @if($shop->contact_email)
                            <div class="contact-item">
                                <span class="contact-item__label">Email:</span>
                                <a href="mailto:{{ $shop->contact_email }}" class="contact-item__link">
                                    {{ $shop->contact_email }}
                                </a>
                            </div>
                        @endif

                        @if($shop->phone_number)
                            <div class="contact-item">
                                <span class="contact-item__label">Phone:</span>
                                <span class="contact-item__value">{{ $shop->phone_number }}</span>
                            </div>
                        @endif

                        @if($shop->facebook_url)
                            <div class="contact-item">
                                <span class="contact-item__label">Facebook:</span>
                                <a href="{{ $shop->facebook_url }}" target="_blank" rel="noopener noreferrer"
                                    class="contact-item__link">
                                    Visit Page
                                </a>
                            </div>
                        @endif

                        @if($shop->instagram_url)
                            <div class="contact-item">
                                <span class="contact-item__label">Instagram:</span>
                                <a href="{{ $shop->instagram_url }}" target="_blank" rel="noopener noreferrer"
                                    class="contact-item__link">
                                    @ {{ basename(parse_url($shop->instagram_url, PHP_URL_PATH)) }}
                                </a>
                            </div>
                        @endif

                        @if($shop->x_url)
                            <div class="contact-item">
                                <span class="contact-item__label">X (Twitter):</span>
                                <a href="{{ $shop->x_url }}" target="_blank" rel="noopener noreferrer" class="contact-item__link">
                                    @ {{ basename(parse_url($shop->x_url, PHP_URL_PATH)) }}
                                </a>
                            </div>
                        @endif

                    </div>
                @endif

                <h2 class="profile-card__section-title mt-xl">Listed By</h2>
                <div class="profile-card__organizer">
                    @if($shop->user && $shop->user->profile && $shop->user->profile->is_public)
                        @if($shop->user->profile->avatar_path)
                            <img src="{{ asset('storage/' . $shop->user->profile->avatar_path) }}" alt="{{ $shop->user->name }}"
                                class="organizer-avatar">
                        @else
                            <img src="/images/default-avatar.png" alt="Default Avatar" class="organizer-avatar">
                        @endif
                        <div class="organizer-info">
                            <span class="organizer-name">
                                <a href="{{ route('practitioners.show', $shop->user->profile) }}">{{ $shop->user->name }}</a>
                            </span>
                            @if($shop->user->profile->tradition)
                                <span class="organizer-tradition">{{ $shop->user->profile->tradition }}</span>
                            @endif
                        </div>
                    @else
                        <div class="organizer-info">
                            <span class="organizer-name" style="color: var(--color-text-muted); font-style: italic;">
                                Member name not publicly available
                            </span>
                        </div>
                    @endif
                </div>

            </div>

        </section>
    </div>
@endsection