@extends('layouts.dashboard')

@section('content')
    <div class="profile-details">

        {{-- Event Hero Header --}}
        <div class="profile-header">
            <div class="profile-header__avatar">
                @if($event->user->profile?->avatar_path)
                    <img src="{{ Storage::url($event->user->profile->avatar_path) }}" alt="{{ $event->user->name }}'s avatar"
                        class="profile-avatar">
                @else
                    <img src="/images/default-avatar.png" alt="Default avatar" class="profile-avatar">
                @endif
            </div>
            <div class="profile-header__info">
                <h1 class="profile-name">{{ $event->title }}</h1>
                <p class="profile-tradition">
                    Hosted by
                    @if($event->user->profile?->is_public)
                        <a href="{{ route('practitioners.show', $event->user->profile) }}"
                            class="profile-tradition-link">{{ $event->user->name }}</a>
                    @else
                        <strong>{{ $event->user->name }}</strong>
                    @endif
                </p>
            </div>
        </div>

        {{-- Detail Cards --}}
        <div class="profile-grid">

            {{-- Dates & Location --}}
            <div class="profile-card">
                <h3>When & Where</h3>
                <p>
                    <strong>Start Date:</strong>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }}
                </p>
                @if($event->end_date && $event->end_date !== $event->start_date)
                    <p>
                        <strong>End Date:</strong>
                        {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                    </p>
                @endif

                <p><strong>City:</strong> {{ $event->city ?? 'Not Provided' }}</p>
                <p><strong>State / Province:</strong> {{ $event->state_province ?? 'Not Provided' }}</p>
                <p><strong>Country:</strong> {{ $countryNames[$event->country] ?? $event->country ?? 'Not Provided' }}</p>
            </div>

            {{-- Organizer Info --}}
            <div class="profile-card">
                <h3>Organizer</h3>
                <p>
                    <strong>Name:</strong>
                    @if($event->user->profile?->is_public)
                        <a href="{{ route('practitioners.show', $event->user->profile) }}"
                            class="profile-link">{{ $event->user->name }}</a>
                    @else
                        {{ $event->user->name }}
                    @endif
                </p>
                @if($event->user->profile?->tradition)
                    <p><strong>Tradition:</strong> {{ $event->user->profile->tradition }}</p>
                @endif
                @if($event->user->profile?->public_email)
                    <p><strong>Email:</strong> {{ $event->user->profile->public_email }}</p>
                @endif
                @if($event->user->profile?->website)
                    <p><strong>Website:</strong>
                        <a href="{{ $event->user->profile->website }}" target="_blank" rel="noopener"
                            class="profile-link">{{ $event->user->profile->website }}</a>
                    </p>
                @endif
            </div>

            {{-- Full Event Details --}}
            <div class="profile-card profile-card--full">
                <h3>About This Event</h3>
                @if($event->details)
                    <p class="profile-bio">{{ $event->details }}</p>
                @else
                    <p class="profile-bio profile-bio--empty">No details provided for this event.</p>
                @endif
            </div>

        </div>

        {{-- Back Link --}}
        <div class="profile-back-action">
            <a href="{{ route('events.browse') }}">
                ← Back to Events
            </a>
        </div>

    </div>
@endsection