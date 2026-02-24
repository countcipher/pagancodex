@extends('layouts.dashboard')

@section('title', 'Edit Event')

@section('content')

    <div class="page-header">
        <h1>Edit Event</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-edit-event">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-edit-event">Edit: {{ $event->title }}</h2>
            </header>

            <form method="POST" action="{{ route('events.update', $event) }}">
                @csrf
                @method('PUT')

                {{-- Event Title --}}
                <div class="form-group">
                    <x-input-label for="title" :value="__('Event Title')" />
                    <x-text-input id="title" type="text" name="title" :value="old('title', $event->title)" required
                        autofocus placeholder="e.g. Summer Solstice Gathering" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                {{-- Dates (Alpine Calendar) --}}
                <div class="form-group">
                    <x-input-label :value="__('Dates')" />
                    <x-alpine-calendar :startDate="old('start_date', $event->start_date)" :endDate="old('end_date', $event->end_date)" />
                    <p class="form-hint">Click a date to select a single day. Click a second date to select a range.</p>
                    <x-input-error :messages="$errors->get('start_date')" />
                </div>

                <hr class="form-divider">

                {{-- Location (Required) --}}
                <div class="form-group">
                    <p class="form-section-subheading" style="margin-bottom: $spacing-md;">Where is this event taking place?
                    </p>
                </div>

                <x-location-select :allowEmpty="false" :country="old('country', $event->country)"
                    :state-province="old('state_province', $event->state_province)" :city="old('city', $event->city)" />

                <hr class="form-divider">

                {{-- Details --}}
                <div class="form-group">
                    <x-input-label for="details" :value="__('Event Details')" />
                    <textarea id="details" name="details" class="form-input form-input--textarea" rows="6" required
                        placeholder="Describe what will happen at the event, what to bring, accessibility info, etc...">{{ old('details', $event->details) }}</textarea>
                    <x-input-error :messages="$errors->get('details')" />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Save Changes</button>
                    <a href="{{ route('events.index') }}" class="btn btn--secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

@endsection