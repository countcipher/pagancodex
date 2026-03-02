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

                                                {{-- Modal Dialog --}}
                                                <div x-show="showModal" class="modal-backdrop" style="display: none;"
                                                    x-transition.opacity @keydown.escape.window="showModal = false">

                                                    <div class="modal-dialog" @click.away="showModal = false">
                                                        <h3 class="modal-title">Delete Article?</h3>
                                                        <p>Are you sure you want to permanently delete
                                                            <strong>{{ $article->title }}</strong>? This action cannot be undone.
                                                        </p>

                                                        <div class="modal-actions">
                                                            <button type="button" @click="showModal = false"
                                                                class="btn btn--secondary">Cancel</button>

                                                            <form method="POST" action="{{ route('articles.destroy', $article) }}"
                                                                style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn--danger">Yes, Delete
                                                                    Article</button>
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
            @endif

        </div>
    </section>

@endsection