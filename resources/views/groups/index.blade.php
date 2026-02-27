@extends('layouts.dashboard')

@section('title', 'My Groups')

@section('content')

    <div class="page-header page-header--flex">
        <h1>My Groups</h1>
        <a href="{{ route('groups.create') }}" class="btn btn--primary">
            + New Group
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-groups">
        <div class="dashboard-panel__body dashboard-panel__body--flush">

            @if($groups->isEmpty())
                <div class="empty-state">
                    <p class="empty-state__text">You haven't created any groups yet.</p>
                    <a href="{{ route('groups.create') }}" class="btn btn--secondary">Start a new group</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Group Name</th>
                                <th>Tradition</th>
                                <th>Location</th>
                                <th class="data-table__column-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td>
                                        <div class="data-table__title">{{ $group->name }}</div>
                                        <div class="data-table__subtext">
                                            @if ($group->is_public)
                                                <span class="status-dot status-dot--active"></span> Listed in directory
                                            @else
                                                <span class="status-dot status-dot--inactive"></span> Hidden from directory
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $group->tradition ?? '—' }}
                                    </td>
                                    <td class="data-table__subtext">
                                        {{ collect([$group->city, $group->state_province, $group->country])->filter()->join(', ') }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions">
                                            <a href="{{ route('groups.edit', $group) }}" class="btn btn--secondary btn--sm">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true"
                                                    class="btn btn--danger btn--sm">Delete</button>

                                                {{-- Modal Dialog --}}
                                                <div x-show="showModal" class="modal-backdrop" style="display: none;"
                                                    x-transition.opacity @keydown.escape.window="showModal = false">

                                                    <div class="modal-dialog" @click.away="showModal = false">
                                                        <h3 class="modal-title">Delete Group?</h3>
                                                        <p>Are you sure you want to permanently delete
                                                            <strong>{{ $group->name }}</strong>? This action cannot be undone.
                                                        </p>

                                                        <div class="modal-actions">
                                                            <button type="button" @click="showModal = false"
                                                                class="btn btn--secondary">Cancel</button>

                                                            <form method="POST" action="{{ route('groups.destroy', $group) }}"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn--danger">Yes, Delete
                                                                    Group</button>
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
                    {{ $groups->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection