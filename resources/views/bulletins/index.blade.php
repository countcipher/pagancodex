@extends('layouts.dashboard')

@section('title', 'My Bulletins')

@section('content')

    <div class="page-header page-header--flex">
        <h1>My Bulletins</h1>
        <a href="{{ route('bulletins.browse') }}" class="btn btn--primary">
            + New Bulletin
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-bulletins">
        <div class="dashboard-panel__body dashboard-panel__body--flush">

            @if($bulletins->isEmpty())
                <div class="empty-state">
                    <p class="empty-state__text">You haven't posted any bulletins yet.</p>
                    <a href="{{ route('bulletins.browse') }}" class="btn btn--secondary">Post your first bulletin</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Bulletin</th>
                                <th>Link</th>
                                <th>Posted</th>
                                <th class="data-table__column-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bulletins as $bulletin)
                                <tr>
                                    <td>
                                        <div class="data-table__title">{{ Str::limit($bulletin->body, 60) }}</div>
                                    </td>
                                    <td class="data-table__subtext">
                                        @if($bulletin->link)
                                            <a href="{{ $bulletin->link }}" target="_blank" rel="noopener">View</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="data-table__subtext">
                                        {{ $bulletin->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions">
                                            <a href="{{ route('bulletins.edit', $bulletin) }}"
                                                class="btn btn--secondary btn--sm">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true"
                                                    class="btn btn--danger btn--sm">Delete</button>

                                                <div x-show="showModal" class="modal-backdrop" style="display: none;"
                                                    x-transition.opacity @keydown.escape.window="showModal = false">

                                                    <div class="modal-dialog" @click.away="showModal = false">
                                                        <h3 class="modal-title">Delete Bulletin?</h3>
                                                        <p>Are you sure you want to permanently delete this bulletin? This action
                                                            cannot be undone.</p>

                                                        <div class="modal-actions">
                                                            <button type="button" @click="showModal = false"
                                                                class="btn btn--secondary">Cancel</button>

                                                            <form method="POST" action="{{ route('bulletins.destroy', $bulletin) }}"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn--danger">Yes, Delete</button>
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

                <div class="pagination-wrapper">
                    {{ $bulletins->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection