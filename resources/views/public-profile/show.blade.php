@extends('layouts.dashboard')

@section('content')
    <div class="profile-details">
        <div class="page-header">
            <h1>Practitioner Details</h1>
        </div>

        <div class="profile-header">
            <div class="profile-header__avatar">
                @if($profile->avatar_path)
                    <img src="{{ Storage::url($profile->avatar_path) }}" alt="{{ $profile->user->name }}"
                        class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="profile-header__info">
                <h2 class="profile-name">{{ $profile->user->name }}</h2>
                @if($profile->tradition)
                    <p class="profile-tradition">{{ $profile->tradition }}</p>
                @else
                    <p class="profile-tradition profile-tradition--empty">Tradition: Not Provided</p>
                @endif

                @if($profile->clergy)
                    <span class="clergy-badge">Clergy</span>
                @endif
            </div>
        </div>

        <div class="profile-grid">
            <div class="profile-card">
                <h3>Location</h3>
                <p><strong>City:</strong> {{ $profile->city ?? 'Not Provided' }}</p>
                <p><strong>State / Province:</strong> {{ $profile->state_province ?? 'Not Provided' }}</p>
                <p><strong>Country:</strong> {{ $countryNames[$profile->country] ?? 'Not Provided' }}</p>
            </div>

            <div class="profile-card">
                <h3>Contact & Online</h3>
                <p><strong>Website:</strong>
                    @if($profile->website)
                        <a href="{{ $profile->website }}" target="_blank" rel="noopener">{{ $profile->website }}</a>
                    @else
                        Not Provided
                    @endif
                </p>
                <p><strong>Public Email:</strong> {{ $profile->public_email ?? 'Not Provided' }}</p>
                <p><strong>Phone Number:</strong> {{ $profile->phone_number ?? 'Not Provided' }}</p>

                <div class="social-links">
                    @if($profile->facebook_url)
                        <a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener"
                            title="Facebook"><x-heroicon-o-link class="social-icon" /> Facebook</a>
                    @endif
                    @if($profile->instagram_url)
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener"
                            title="Instagram"><x-heroicon-o-link class="social-icon" /> Instagram</a>
                    @endif
                    @if($profile->x_url)
                        <a href="{{ $profile->x_url }}" target="_blank" rel="noopener"
                            title="X (Formerly Twitter)"><x-heroicon-o-link class="social-icon" /> X (Twitter)</a>
                    @endif
                </div>
            </div>

            <div class="profile-card profile-card--full">
                <h3>About</h3>
                @if($profile->bio)
                    <p class="profile-bio">{{ $profile->bio }}</p>
                @else
                    <p class="profile-bio profile-bio--empty">Biography: Not Provided</p>
                @endif
            </div>
        </div>
    </div>
@endsection