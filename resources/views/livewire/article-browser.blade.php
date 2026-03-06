<div class="directory-wrapper" wire:loading.class="opacity-50">
    {{-- LEFT COLUMN: Filters --}}
    <aside class="directory-filters">
        <p class="directory-filters__title">Filter</p>

        <div class="directory-filters__group">
            <label for="search" class="directory-filters__label">Search</label>
            <input type="search" id="search" wire:model.live.debounce.300ms="search" class="directory-filters__input"
                placeholder="Title or description">
        </div>

        <div class="directory-filters__group">
            <label for="sort" class="directory-filters__label">Sort By</label>
            <select id="sort" wire:model.live="sort" class="directory-filters__select">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
            </select>
        </div>

        @if($search)
            <button wire:click="$set('search', '')" class="directory-filters__reset">
                Clear Filters
            </button>
        @endif
    </aside>

    <section class="directory-results" aria-live="polite" aria-label="Article results">

        <header class="directory-results__header">
            <h2 class="directory-results__title">Articles</h2>
            <span class="directory-results__count">{{ $articles->total() }}
                {{ Str::plural('article', $articles->total()) }}</span>
        </header>

        <div wire:loading.class="opacity-50" class="article-browse-grid">
            @forelse ($articles as $article)
                <a href="{{ route('articles.show', $article) }}" class="article-browse-card"
                    aria-label="Article: {{ $article->title }}">

                    @if($article->image_path)
                        <img src="{{ Storage::url($article->image_path) }}" alt="{{ $article->title }}"
                            class="article-browse-card__image" loading="lazy">
                    @endif

                    <div class="article-browse-card__body">
                        <h3 class="article-browse-card__title">{{ $article->title }}</h3>

                        <div class="article-browse-card__meta">
                            <span>
                                <x-heroicon-o-user class="article-browse-card__icon" />
                                {{ $article->user->name }}
                            </span>
                            <span>
                                <x-heroicon-o-clock class="article-browse-card__icon" />
                                {{ $article->created_at->format('M j, Y') }}
                            </span>
                        </div>

                        @if($article->description)
                            <p class="article-browse-card__desc">{{ Str::limit($article->description, 150) }}</p>
                        @endif
                    </div>

                </a>
            @empty
                <div class="directory-empty">
                    <p class="directory-empty__text">No articles found matching your criteria.</p>
                    <button wire:click="$set('search', '')" class="directory-empty__action">
                        Clear Filters
                    </button>
                </div>
            @endforelse
        </div>

        <div class="directory-pagination">
            {{ $articles->links() }}
        </div>

    </section>
</div>