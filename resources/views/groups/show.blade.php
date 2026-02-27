@extends('layouts.dashboard')

@section('title', $group->name)

@section('content')
    <div class="profile-details">

        {{-- Group Hero Header --}}
        <div class="profile-header">
            <div class="profile-header__avatar">
                {{-- @if($group->user->profile?->avatar_path)
                    <img src="{{ Storage::url($group->user->profile->avatar_path) }}" alt="{{ $group->name }}'s avatar"
                        class="profile-avatar">
                @else
                    <div class="profile-avatar-placeholder">
                        {{ substr($group->name, 0, 1) }}
                    </div>
                @endif --}}
            </div>
            <div class="profile-header__info">
                <h1 class="profile-name">{{ $group->name }}</h1>
                <p class="profile-tradition">
                    {{ $group->tradition ?? 'Eclectic / All Paths Welcome' }}
                </p>
            </div>
        </div>

        {{-- Detail Cards --}}
        <div class="profile-grid">

            {{-- Location --}}
            <div class="profile-card">
                <h3>Location</h3>
                <p><strong>City:</strong> {{ $group->city ?? 'Not Provided' }}</p>
                <p><strong>State / Province:</strong> {{ $group->state_province ?? 'Not Provided' }}</p>
                <p><strong>Country:</strong> {{ $group->country ?? 'Not Provided' }}</p>
                
                @if ($group->has_clergy)
                    <h3 style="margin-top: 1.5rem;">Services</h3>
                    <p class="profile-services-badge">
                        <span class="profile-services-badge__icon">★</span> 
                        Legal clergy available for rituals/sacraments.
                    </p>
                @endif
            </div>

            {{-- Contact Info --}}
            <div class="profile-card">
                <h3>Contact & Links</h3>
                
                @if ($group->contact_email)
                    <p><strong>Email:</strong> <a href="mailto:{{ $group->contact_email }}" class="profile-link">{{ $group->contact_email }}</a></p>
                @endif

                @if ($group->phone_number)
                    <p><strong>Phone:</strong> {{ $group->phone_number }}</p>
                @endif

                @if ($group->website)
                    <p><strong>Website:</strong> 
                        <a href="{{ $group->website }}" target="_blank" rel="noopener" class="profile-link">{{ $group->website }}</a>
                    </p>
                @endif

                @if ($group->facebook_url)
                    <p><strong>Facebook:</strong> 
                        <a href="{{ $group->facebook_url }}" target="_blank" rel="noopener" class="profile-link">Visit Page</a>
                    </p>
                @endif
                
                @if ($group->instagram_url)
                    <p><strong>Instagram:</strong> 
                        <a href="{{ $group->instagram_url }}" target="_blank" rel="noopener" class="profile-link">Visit Profile</a>
                    </p>
                @endif
                
                @if ($group->x_url)
                    <p><strong>X (Twitter):</strong> 
                        <a href="{{ $group->x_url }}" target="_blank" rel="noopener" class="profile-link">Visit Profile</a>
                    </p>
                @endif
                
                @if (!$group->contact_email && !$group->phone_number && !$group->website && !$group->facebook_url && !$group->instagram_url && !$group->x_url)
                    <p>No public contact information provided.</p>
                @endif
                
                <hr class="profile-section-divider" />
                
                <h3>Listed By</h3>
                <p>
                    @if($group->user->profile?->is_public)
                        <a href="{{ route('practitioners.show', $group->user->profile) }}" class="profile-link">
                            {{ $group->user->name }}
                        </a>
                    @else
                        Member name not publically available.
                    @endif
                </p>
            </div>

            {{-- Full Description --}}
            <div class="profile-card profile-card--full">
                <h3>About The Group</h3>
                @if($group->description)
                    <p class="profile-bio">{{ $group->description }}</p>
                @else
                    <p class="profile-bio profile-bio--empty">No description provided for this group.</p>
                @endif
            </div>

        </div>

        {{-- Back Link --}}
        <div class="profile-back-action">
            <a href="{{ route('groups.browse') }}">
                ← Back to Groups Directory
            </a>
        </div>

    </div>
@endsection
