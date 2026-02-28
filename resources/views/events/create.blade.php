@extends('layouts.dashboard')

@section('title', 'Create Event')

@section('content')

    <div class="page-header">
        <h1>Create Event</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-create-event">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-create-event">Add a New Event</h2>
            </header>

            <div class="notice notice--warning" role="note">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="notice__icon"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <strong>Privacy notice:</strong> Any information you enter here will be visible to <em>all visitors</em>
                    to Pagan Codex — including people who are not logged in — if your event is listed in the public
                    directory. Only share what you are comfortable making public.
                </div>
            </div>

            <form method="POST" action="{{ route('events.store') }}">
                @csrf

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_public" class="form-toggle">
                        <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                        <span>List this event in the public directory</span>
                    </label>
                    <p class="form-hint">Uncheck to hide this event from search results and the directory. You can still
                        share it via direct link.</p>
                </div>

                <hr class="form-divider">

                {{-- Event Title --}}
                <div class="form-group">
                    <x-input-label for="title" :value="__('Event Title')" />
                    <x-text-input id="title" type="text" name="title" :value="old('title')" required autofocus
                        placeholder="e.g. Summer Solstice Gathering" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                {{-- Dates (Alpine Calendar) --}}
                <div class="form-group">
                    <x-input-label :value="__('Dates')" />
                    <x-alpine-calendar />
                    <p class="form-hint">Click a date to select a single day. Click a second date to select a range.</p>
                    <x-input-error :messages="$errors->get('start_date')" />
                </div>

                <hr class="form-divider">

                {{-- Location (Required) --}}
                <div class="form-group">
                    <p class="form-section-subheading" style="margin-bottom: $spacing-md;">Where is this event taking place?
                    </p>
                </div>

                <x-location-select :allowEmpty="false" />

                <hr class="form-divider">

                {{-- Details --}}
                <div class="form-group">
                    <x-input-label for="details" :value="__('Event Details')" />
                    <textarea id="details" name="details" class="form-input form-input--textarea" rows="6" required
                        placeholder="Describe what will happen at the event, what to bring, accessibility info, etc...">{{ old('details') }}</textarea>
                    <x-input-error :messages="$errors->get('details')" />
                </div>

                <hr class="form-divider">

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Create Event</button>
                    <a href="{{ route('dashboard') }}" class="btn btn--secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

@endsection