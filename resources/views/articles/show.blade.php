@extends('layouts.dashboard')

@section('title', $article->title . ' — Pagan Codex')

@section('content')
    <article class="article-display">

        {{-- Featured Image Banner --}}
        @if($article->image_path)
            <div class="article-display__banner">
                <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}"
                    class="article-display__banner-img">
            </div>
        @endif

        {{-- Article Header --}}
        <header class="article-display__header">
            <h1 class="article-display__title">{{ $article->title }}</h1>

            <div class="article-display__meta">
                <span class="article-display__author">
                    <x-heroicon-o-user class="article-display__meta-icon" />
                    {{ $article->user->name }}
                </span>
                <span class="article-display__date">
                    <x-heroicon-o-clock class="article-display__meta-icon" />
                    {{ $article->created_at->format('F j, Y') }}
                </span>
            </div>

            @if($article->description)
                <p class="article-display__description">{{ $article->description }}</p>
            @endif
        </header>

        <hr class="article-display__divider">

        {{-- Article Body (HTML from TinyMCE) --}}
        <div class="article-display__body">
            {!! $article->content !!}
        </div>

        {{-- Back Link --}}
        <div class="article-display__back">
            <a href="{{ route('home') }}">← Back to Home</a>
        </div>

    </article>
@endsection