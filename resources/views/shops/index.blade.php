@extends('layouts.dashboard')

@section('title', 'My Shops')

@section('content')

    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h1>My Shops</h1>
        <a href="{{ route('shops.create') }}" class="btn btn--primary">
            + New Shop
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-shops">
        <div class="dashboard-panel__body" style="padding: 0;">

            @if($shops->isEmpty())
                <div style="padding: 2rem; text-align: center;">
                    <p style="color: #7A6A58; font-style: italic; margin-bottom: 1rem;">You haven't listed any shops yet.</p>
                    <a href="{{ route('shops.create') }}" class="btn btn--secondary">List your first shop</a>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Shop Name</th>
                                <th>Location</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #2A1A08;">{{ $shop->name }}</div>
                                        <div style="margin-top: 0.25rem; font-size: 0.85rem; color: #7A6A58;">
                                            @if ($shop->is_public)
                                                <span class="status-dot status-dot--active"></span> Listed in directory
                                            @else
                                                <span class="status-dot status-dot--inactive"></span> Hidden from directory
                                            @endif
                                        </div>
                                    </td>
                                    <td style="color: #7A6A58; font-size: 0.85rem;">
                                        {{ collect([$shop->city, $shop->state_province, $shop->country])->filter()->join(', ') }}
                                    </td>
                                    <td>
                                        <div class="data-table__actions"
                                            style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                            <a href="{{ route('shops.edit', $shop) }}" class="btn btn--secondary"
                                                style="padding: 0.25rem 0.75rem; font-size: 0.8rem; line-height: 1.5; height: auto;">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true" class="btn btn--danger"
                                                    style="padding: 0.25rem 0.75rem; font-size: 0.8rem; line-height: 1.5; height: auto;">Delete</button>

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
                <div style="padding: 1.5rem; border-top: 1px solid #DDD5C8;">
                    {{ $shops->links() }}
                </div>
            @endif

        </div>
    </section>

@endsection