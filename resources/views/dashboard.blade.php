@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="page-header">
        <h1>Welcome back, {{ auth()->user()->name ?? 'Traveller' }}</h1>
    </div>

    {{-- Quick Actions --}}
    <div class="dashboard-actions" role="list" aria-label="Quick actions">
        <a href="{{ route('public-profile.edit') }}" class="action-card" role="listitem">
            <x-heroicon-o-user class="action-card__icon" aria-hidden="true" />
            Edit Public Profile
        </a>
        <a href="#" class="action-card" role="listitem">
            <x-heroicon-o-calendar-days class="action-card__icon" aria-hidden="true" />
            New Event
        </a>
        <a href="#" class="action-card" role="listitem">
            <x-heroicon-o-user-group class="action-card__icon" aria-hidden="true" />
            New Group
        </a>
        <a href="#" class="action-card" role="listitem">
            <x-heroicon-o-shopping-bag class="action-card__icon" aria-hidden="true" />
            New Shop
        </a>
    </div>

    {{-- Profile Summary --}}
    @php
        $hasProfileData = $profile && ($profile->tradition || $profile->bio || $profile->city || $profile->avatar_path || $profile->website);
    @endphp
    <section class="dashboard-panel" aria-labelledby="panel-profile">
        <h2 class="dashboard-panel__title" id="panel-profile">Your Public Profile</h2>
        <div class="dashboard-panel__body">
            @if (!$hasProfileData)
                <p>You haven't filled out your public profile yet. Let the community know who you are — your tradition,
                    location, and what you're seeking.</p>
                <div class="panel-cta">
                    <a href="{{ route('public-profile.edit') }}" class="btn btn--primary">Complete Your Profile</a>
                </div>
            @else
                <div class="profile-summary">
                    @if ($profile->avatar_path)
                        <img src="{{ Storage::url($profile->avatar_path) }}" alt="Profile photo" class="profile-summary__avatar">
                    @endif
                    <div class="profile-summary__details">
                        <p class="profile-summary__name">{{ auth()->user()->name }}
                            @if ($profile->clergy)
                                <span class="profile-badge">Clergy</span>
                            @endif
                        </p>
                        @if ($profile->tradition)
                            <p class="profile-summary__meta">{{ $profile->tradition }}</p>
                        @endif
                        @if ($profile->city || $profile->state_province || $profile->country)
                            <p class="profile-summary__meta">
                                {{ collect([$profile->city, $profile->state_province, $profile->country])->filter()->join(', ') }}
                            </p>
                        @endif
                        <p class="profile-summary__visibility">
                            @if ($profile->is_public)
                                <span class="status-dot status-dot--active"></span> Listed in directory
                            @else
                                <span class="status-dot status-dot--inactive"></span> Hidden from directory
                            @endif
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- My Listings --}}
    <section class="dashboard-panel" aria-labelledby="panel-listings">
        <h2 class="dashboard-panel__title" id="panel-listings">My Listings</h2>
        <div class="dashboard-panel__body">
            <p>You haven't created any listings yet. Add an event, group, or shop to appear in the directory.</p>
        </div>
    </section>

    {{-- Account --}}
    <section class="dashboard-panel" aria-labelledby="panel-account">
        <h2 class="dashboard-panel__title" id="panel-account">Account Settings</h2>
        <div class="dashboard-panel__body">
            <p>Manage your email address, password, and notification preferences.</p>
        </div>
    </section>

@endsection