@extends('layouts.dashboard')

@section('content')
    <div class="profile-details">
        <div class="page-header">
            <h1>Member Details</h1>
        </div>

        <div class="profile-header">
            <div class="profile-header__avatar">
                @if($profile->avatar_path)
                    <img src="{{ Storage::url($profile->avatar_path) }}" alt="{{ $profile->user->name }}"
                        class="profile-avatar">
                @else
                    <img src="/images/default-avatar.png" alt="Default avatar" class="profile-avatar">
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

                @if($profile->website)
                    <p><strong>Website:</strong>
                        <a href="{{ $profile->website }}" target="_blank" rel="noopener"
                            class="profile-link">{{ str_replace(['http://', 'https://'], '', rtrim($profile->website, '/')) }}</a>
                    </p>
                @endif

                @if($profile->public_email)
                    <p><strong>Public Email:</strong>
                        <a href="mailto:{{ $profile->public_email }}" class="profile-link">{{ $profile->public_email }}</a>
                    </p>
                @endif

                @if($profile->phone_number)
                    <p><strong>Phone Number:</strong> {{ $profile->phone_number }}</p>
                @endif

                @if($profile->facebook_url)
                    <p><strong>Facebook:</strong>
                        <a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener" class="profile-link">Visit
                            Page</a>
                    </p>
                @endif

                @if($profile->instagram_url)
                    <p><strong>Instagram:</strong>
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener" class="profile-link">Visit
                            Page</a>
                    </p>
                @endif

                @if($profile->x_url)
                    <p><strong>X (Twitter):</strong>
                        <a href="{{ $profile->x_url }}" target="_blank" rel="noopener" class="profile-link">Visit Page</a>
                    </p>
                @endif

                @if(!$profile->website && !$profile->public_email && !$profile->phone_number && !$profile->facebook_url && !$profile->instagram_url && !$profile->x_url)
                    <p>No contact or online information provided.</p>
                @endif
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