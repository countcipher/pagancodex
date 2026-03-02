@extends('layouts.dashboard')

@section('title', 'My Articles')

@section('content')

    <div class="page-header page-header--flex">
        <h1>My Articles</h1>
        <a href="{{ route('articles.create') }}" class="btn btn--primary">
            + New Article
        </a>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-my-articles">
        <div class="dashboard-panel__body dashboard-panel__body--flush">

            @if($articles->isEmpty())
                <div class="empty-state">
                    <p class="empty-state__text">You haven't written any articles yet.</p>
                    <a href="{{ route('articles.create') }}" class="btn btn--secondary">Write your first article</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Article Title</th>
                                <th>Status</th>
                                <th class="data-table__column-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>
                                        <div class="data-table__title">{{ $article->title }}</div>
                                    </td>
                                    <td>
                                        @if ($article->is_published)
                                            <span class="status-dot status-dot--active"></span> Published
                                        @else
                                            <span class="status-dot status-dot--inactive"></span> Draft
                                        @endif
                                    </td>
                                    <td>
                                        <div class="data-table__actions">
                                            <a href="{{ route('articles.edit', $article) }}"
                                                class="btn btn--secondary btn--sm">Edit</a>

                                            {{-- Alpine powered Delete Button/Modal --}}
                                            <div x-data="{ showModal: false }" style="display: flex; align-items: center;">
                                                <button type="button" @click="showModal = true"
                                                    class="btn btn--danger btn--sm">Delete</button>

                                                <template x-teleport="body">
                                                    <div x-show="showModal" class="modal-overlay" style="display: none;">
                                                        <div class="modal" @click.away="showModal = false">
                                                            <div class="modal__header">
                                                                <h2 class="modal__title">Delete Article</h2>
                                                                <button @click="showModal = false"
                                                                    class="modal__close">&times;</button>
                                                            </div>
                                                            <div class="modal__body">
                                                                <p>Are you sure you want to delete
                                                                    <strong>{{ $article->title }}</strong>? This action cannot be
                                                                    undone.</p>
                                                            </div>
                                                            <div class="modal__footer">
                                                                <button @click="showModal = false"
                                                                    class="btn btn--secondary">Cancel</button>
                                                                <form action="{{ route('articles.destroy', $article) }}"
                                                                    method="POST" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn--danger">Yes,
                                                                        Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </section>

@endsection