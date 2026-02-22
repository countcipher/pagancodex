@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    <div class="page-header">
        <h1>Welcome back, {{ auth()->user()->name ?? 'Traveller' }}</h1>
    </div>

    {{-- Quick Actions --}}
    <div class="dashboard-actions" role="list" aria-label="Quick actions">
        <a href="#" class="action-card" role="listitem">
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
    <section class="dashboard-panel" aria-labelledby="panel-profile">
        <h2 class="dashboard-panel__title" id="panel-profile">Your Public Profile</h2>
        <div class="dashboard-panel__body">
            <p>You haven't filled out your public profile yet. Let the community know who you are — your tradition, location, and what you're seeking.</p>
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
