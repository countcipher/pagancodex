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
        <a href="{{ route('events.create') }}" class="action-card" role="listitem">
            <x-heroicon-o-calendar-days class="action-card__icon" aria-hidden="true" />
            New Event
        </a>
        <a href="{{ route('groups.create') }}" class="action-card" role="listitem">
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

    {{-- Community Impact (Summary) --}}
    <section class="dashboard-panel" aria-labelledby="panel-impact">
        <div class="dashboard-panel__header-flex">
            <h2 class="dashboard-panel__title" id="panel-impact" style="margin-bottom: 0;">Community Impact</h2>
        </div>
        <div class="dashboard-panel__body">
            <div class="metrics-grid">

                {{-- Events Metric --}}
                <div class="metric-card">
                    <div class="metric-card__header">
                        <x-heroicon-o-calendar class="metric-card__icon" aria-hidden="true" />
                        <h3 class="metric-card__title">Events Hosted</h3>
                    </div>
                    <p class="metric-card__value">{{ $eventsCount }}</p>
                    @if ($eventsCount > 0)
                        <a href="{{ route('events.index') }}" class="metric-card__link">Manage Events &rarr;</a>
                    @else
                        <a href="{{ route('events.create') }}" class="metric-card__link">Create an Event &rarr;</a>
                    @endif
                </div>

                {{-- Groups Metric --}}
                <div class="metric-card">
                    <div class="metric-card__header">
                        <x-heroicon-o-user-group class="metric-card__icon" aria-hidden="true" />
                        <h3 class="metric-card__title">Groups Managed</h3>
                    </div>
                    <p class="metric-card__value">{{ $groupsCount }}</p>
                    @if ($groupsCount > 0)
                        <a href="{{ route('groups.index') }}" class="metric-card__link">Manage Groups &rarr;</a>
                    @else
                        <a href="{{ route('groups.create') }}" class="metric-card__link">Create a Group &rarr;</a>
                    @endif
                </div>

                {{-- Shops Metric (Placeholder for future) --}}
                <div class="metric-card">
                    <div class="metric-card__header">
                        <x-heroicon-o-shopping-bag class="metric-card__icon" aria-hidden="true" />
                        <h3 class="metric-card__title">Shops Owned</h3>
                    </div>
                    <p class="metric-card__value">0</p>
                    <a href="#" class="metric-card__link">Create a Shop &rarr;</a>
                </div>

            </div>
        </div>
    </section>

@endsection