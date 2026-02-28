@extends('layouts.dashboard')

@section('title', $shop->name . ' — Pagan Codex')

@section('content')
    <div class="profile-details">

        {{-- Shop Hero Header --}}
        <div class="profile-header">
            <div class="profile-header__avatar">
                {{-- Shop avatar placeholder if added in future --}}
            </div>
            <div class="profile-header__info">
                <h1 class="profile-name">{{ $shop->name }}</h1>
            </div>
        </div>

        {{-- Detail Cards --}}
        <div class="profile-grid">

            {{-- Location & Hours --}}
            <div class="profile-card">
                <h3>Location</h3>
                <p><strong>City:</strong> {{ $shop->city ?? 'Not Provided' }}</p>
                <p><strong>State / Province:</strong> {{ $shop->state_province ?? 'Not Provided' }}</p>
                <p><strong>Country:</strong> {{ $shop->country ?? 'Not Provided' }}</p>

                <hr class="profile-section-divider" />

                <h3>Store Hours</h3>
                @php
                    $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                    $hasHours = collect($days)->contains(fn($day) => !empty($shop->{"hours_{$day}"}));
                @endphp

                @if($hasHours)
                    @foreach($days as $day)
                        @if($shop->{"hours_{$day}"})
                            <p><strong>{{ ucfirst($day) }}:</strong> {{ $shop->{"hours_{$day}"} }}</p>
                        @endif
                    @endforeach
                @else
                    <p>No hours listed.</p>
                @endif
            </div>

            {{-- Contact Info --}}
            <div class="profile-card">
                <h3>Contact & Links</h3>

                @if ($shop->contact_email)
                    <p><strong>Email:</strong> <a href="mailto:{{ $shop->contact_email }}"
                            class="profile-link">{{ $shop->contact_email }}</a></p>
                @endif

                @if ($shop->phone_number)
                    <p><strong>Phone:</strong> {{ $shop->phone_number }}</p>
                @endif

                @if ($shop->website)
                    <p><strong>Website:</strong>
                        <a href="{{ $shop->website }}" target="_blank" rel="noopener"
                            class="profile-link">{{ str_replace(['http://', 'https://'], '', rtrim($shop->website, '/')) }}</a>
                    </p>
                @endif

                @if ($shop->facebook_url)
                    <p><strong>Facebook:</strong>
                        <a href="{{ $shop->facebook_url }}" target="_blank" rel="noopener" class="profile-link">Visit Page</a>
                    </p>
                @endif

                @if ($shop->instagram_url)
                    <p><strong>Instagram:</strong>
                        <a href="{{ $shop->instagram_url }}" target="_blank" rel="noopener" class="profile-link">@
                            {{ basename(parse_url($shop->instagram_url, PHP_URL_PATH)) }}</a>
                    </p>
                @endif

                @if ($shop->x_url)
                    <p><strong>X (Twitter):</strong>
                        <a href="{{ $shop->x_url }}" target="_blank" rel="noopener" class="profile-link">@
                            {{ basename(parse_url($shop->x_url, PHP_URL_PATH)) }}</a>
                    </p>
                @endif

                @if (!$shop->contact_email && !$shop->phone_number && !$shop->website && !$shop->facebook_url && !$shop->instagram_url && !$shop->x_url)
                    <p>No public contact information provided.</p>
                @endif

                <hr class="profile-section-divider" />

                <h3>Listed By</h3>
                <p>
                    @if($shop->user && $shop->user->profile && $shop->user->profile->is_public)
                        <a href="{{ route('practitioners.show', $shop->user->profile) }}" class="profile-link">
                            {{ $shop->user->name }}
                        </a>
                    @else
                        Member name not publicly available.
                    @endif
                </p>
            </div>

            {{-- Full Description --}}
            <div class="profile-card profile-card--full">
                <h3>About The Shop</h3>
                @if($shop->description)
                    <p class="profile-bio">{{ $shop->description }}</p>
                @else
                    <p class="profile-bio profile-bio--empty">No description provided for this shop.</p>
                @endif
            </div>

        </div>

        {{-- Back Link --}}
        <div class="profile-back-action">
            <a href="{{ route('shops.browse') }}">
                ← Back to Shops Directory
            </a>
        </div>

    </div>
@endsection