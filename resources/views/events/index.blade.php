@extends('layouts.dashboard')

@section('title', 'My Events')

@section('content')

    <div class="page-header page-header--flex">
        <h1>My Events</h1>
        <a href="{{ route('events.create') }}" class="btn btn--primary">
            + New Event
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-events">
        <div class="dashboard-panel__body dashboard-panel__body--flush"> {{-- Removing padding for edge-to-edge table --}}

            @if($events->isEmpty())
                <div class="empty-state">
                    <p class="empty-state__text">You haven't created any events yet.</p>
                    <a href="{{ route('events.create') }}" class="btn btn--secondary">Plan your first event</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Date(s)</th>
                                <th>Location</th>
                                <th class="data-table__column-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <td>
                                        <div class="data-table__title">{{ $event->title }}</div>
                                        <div class="data-table__subtext">
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
                                    <td class="data-table__subtext">
                                        {{ collect([$event->city, $event->state_province, $event->country])->filter()->join(', ') }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions">
                                            <a href="{{ route('events.edit', $event) }}" class="btn btn--secondary btn--sm">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true"
                                                    class="btn btn--danger btn--sm">Delete</button>

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
                <div class="pagination-wrapper">
                    {{ $events->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection