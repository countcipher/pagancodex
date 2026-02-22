@extends('layouts.dashboard')

@section('title', 'Account Settings')

@section('content')

    <div class="page-header">
        <h1>Account Settings</h1>
    </div>

    {{-- Update Name & Email --}}
    <section class="dashboard-panel" aria-labelledby="panel-profile-info">
        <div class="dashboard-panel__body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </section>

    {{-- Update Password --}}
    <section class="dashboard-panel" aria-labelledby="panel-password">
        <div class="dashboard-panel__body">
            @include('profile.partials.update-password-form')
        </div>
    </section>

    {{-- Delete Account --}}
    <section class="dashboard-panel dashboard-panel--danger" aria-labelledby="panel-delete">
        <div class="dashboard-panel__body">
            @include('profile.partials.delete-user-form')
        </div>
    </section>

@endsection
