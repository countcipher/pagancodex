@extends('layouts.dashboard')

@section('title', 'My Shops')

@section('content')

    <div class="page-header page-header--flex">
        <h1>My Shops</h1>
        <a href="{{ route('shops.create') }}" class="btn btn--primary">
            + New Shop
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-shops">
        <div class="dashboard-panel__body dashboard-panel__body--flush">

            @if($shops->isEmpty())
                <div class="empty-state">
                    <p class="empty-state__text">You haven't listed any shops yet.</p>
                    <a href="{{ route('shops.create') }}" class="btn btn--secondary">List your first shop</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Shop Name</th>
                                <th>Location</th>
                                <th class="data-table__column-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <div class="data-table__title">{{ $shop->name }}</div>
                                        <div class="data-table__subtext">
                                            @if ($shop->is_public)
                                                <span class="status-dot status-dot--active"></span> Listed in directory
                                            @else
                                                <span class="status-dot status-dot--inactive"></span> Hidden from directory
                                            @endif
                                        </div>
                                    </td>
                                    <td class="data-table__subtext">
                                        {{ collect([$shop->city, $shop->state_province, $shop->country])->filter()->join(', ') }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions">
                                            <a href="{{ route('shops.edit', $shop) }}" class="btn btn--secondary btn--sm">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true"
                                                    class="btn btn--danger btn--sm">Delete</button>

                                                {{-- Modal Dialog --}}
                                                <div x-show="showModal" class="modal-backdrop" style="display: none;"
                                                    x-transition.opacity @keydown.escape.window="showModal = false">

                                                    <div class="modal-dialog" @click.away="showModal = false">
                                                        <h3 class="modal-title">Delete Shop?</h3>
                                                        <p>Are you sure you want to permanently delete
                                                            <strong>{{ $shop->name }}</strong>? This action cannot be undone.
                                                        </p>

                                                        <div class="modal-actions">
                                                            <button type="button" @click="showModal = false"
                                                                class="btn btn--secondary">Cancel</button>

                                                            <form method="POST" action="{{ route('shops.destroy', $shop) }}"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn--danger">Yes, Delete
                                                                    Shop</button>
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
                    {{ $shops->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection