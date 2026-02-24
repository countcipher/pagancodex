@extends('layouts.dashboard')

@section('title', 'My Events')

@section('content')

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>My Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn--primary">
            + New Event
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-events">
        <div class="dashboard-panel__body" style="padding: 0;"> {{-- Removing padding for edge-to-edge table --}}

            @if($events->isEmpty())
                <div style="padding: 2rem; text-align: center;">
                    <p style="color: #7A6A58; font-style: italic; margin-bottom: 1rem;">You haven't created any events yet.</p>
                    <a href="{{ route('events.create') }}" class="btn btn--secondary">Plan your first event</a>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Date(s)</th>
                                <th>Location</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #2A1A08;">{{ $event->title }}</div>
                                        <div style="margin-top: 0.25rem; font-size: 0.85rem; color: #7A6A58;">
                                            @if ($event->is_public)
                                                <span class="status-dot status-dot--active"></span> Listed in directory
                                            @else
                                                <span class="status-dot status-dot--inactive"></span> Hidden from directory
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($event->start_date)->format('M j, Y') }}
                                        @if($event->end_date && $event->end_date !== $event->start_date)
                                            — {{ \Carbon\Carbon::parse($event->end_date)->format('M j, Y') }}
                                        @endif
                                    </td>
                                    <td style="color: #7A6A58; font-size: 0.85rem;">
                                        {{ collect([$event->city, $event->state_province, $event->country])->filter()->join(', ') }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions"
                                            style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn--secondary"
                                                style="padding: 0.25rem 0.75rem; font-size: 0.8rem; line-height: 1.5; height: auto;">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true" class="btn btn--danger"
                                                    style="padding: 0.25rem 0.75rem; font-size: 0.8rem; line-height: 1.5; height: auto;">Delete</button>

                                                {{-- Modal Dialog --}}
                                                <div x-show="showModal" class="modal-backdrop" style="display: none;"
                                                    x-transition.opacity @keydown.escape.window="showModal = false">

                                                    <div class="modal-dialog" @click.away="showModal = false">
                                                        <h3 class="modal-title">Delete Event?</h3>
                                                        <p>Are you sure you want to permanently delete
                                                            <strong>{{ $event->title }}</strong>? This action cannot be undone.
                                                        </p>

                                                        <div class="modal-actions">
                                                            <button type="button" @click="showModal = false"
                                                                class="btn btn--secondary">Cancel</button>

                                                            <form method="POST" action="{{ route('events.destroy', $event) }}"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn--danger">Yes, Delete
                                                                    Event</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links --}}
                <div style="padding: 1.5rem; border-top: 1px solid #DDD5C8;">
                    {{ $events->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection