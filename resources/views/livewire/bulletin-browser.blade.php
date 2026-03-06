<div class="bulletin-wrapper">

    <header class="directory-results__header">
        <h2 class="directory-results__title">Bulletin Board</h2>
        <span class="directory-results__count">{{ $bulletins->total() }}
            {{ Str::plural('post', $bulletins->total()) }}</span>
    </header>

    {{-- New Bulletin Form (auth only) --}}
    @auth
        <div class="bulletin-form-card">
            <form method="POST" action="{{ route('bulletins.store') }}" x-data="{ body: '', link: '' }">
                @csrf

                <div class="bulletin-form-card__row">
                    <img src="{{ auth()->user()->profile?->avatar_path ? Storage::url(auth()->user()->profile->avatar_path) : '/images/default-avatar.png' }}"
                        alt="Your avatar" class="bulletin-form-card__avatar">

                    <div class="bulletin-form-card__fields">
                        <div class="form-group" style="margin-bottom: 0.5rem;">
                            <textarea name="body" x-model="body" maxlength="200" class="bulletin-form-card__textarea"
                                placeholder="Share something with the community…" required></textarea>
                            <span class="bulletin-form-card__counter"
                                :class="{ 'bulletin-form-card__counter--warn': body.length > 180 }"
                                x-text="body.length + ' / 200'"></span>
                            <x-input-error :messages="$errors->get('body')" />
                        </div>

                        <div class="bulletin-form-card__link-row">
                            <input type="url" name="link" x-model="link" class="bulletin-form-card__link-input"
                                placeholder="Optional link (https://...)">
                            <button type="submit" class="btn btn--primary btn--sm"
                                :disabled="body.trim().length === 0">Post</button>
                        </div>
                        <x-input-error :messages="$errors->get('link')" />
                    </div>
                </div>
            </form>
        </div>
    @else
        <div class="bulletin-login-prompt">
            <a href="{{ route('login') }}">Log in</a> or <a href="{{ route('register') }}">create an account</a> to post on
            the bulletin board.
        </div>
    @endauth

    {{-- Bulletin Feed --}}
    @if($bulletins->isEmpty())
        <div class="directory-empty">
            <p>No bulletins yet. Be the first to post!</p>
        </div>
    @else
        <div class="bulletin-feed">
            @foreach($bulletins as $bulletin)
                <div class="bulletin-post">
                    <div class="bulletin-post__avatar-col">
                        <img src="{{ $bulletin->user->profile?->avatar_path ? Storage::url($bulletin->user->profile->avatar_path) : '/images/default-avatar.png' }}"
                            alt="{{ $bulletin->user->name }}'s avatar" class="bulletin-post__avatar" loading="lazy">
                    </div>

                    <div class="bulletin-post__content">
                        <div class="bulletin-post__header">
                            <span class="bulletin-post__name">{{ $bulletin->user->name }}</span>
                            <span class="bulletin-post__time">{{ $bulletin->created_at->diffForHumans() }}</span>

                            {{-- Admin delete button --}}
                            @auth
                                @if(auth()->user()->role >= 10 && auth()->user()->id != $bulletin->user_id)
                                    <form method="POST" action="{{ route('bulletins.destroy', $bulletin) }}"
                                        class="bulletin-post__admin-delete" onsubmit="return confirm('Delete this bulletin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bulletin-post__delete-btn" title="Delete this post (Admin)">
                                            <x-heroicon-o-trash class="bulletin-post__delete-icon" />
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <p class="bulletin-post__body">{{ $bulletin->body }}</p>

                        @if($bulletin->link)
                            <a href="{{ $bulletin->link }}" target="_blank" rel="noopener" class="bulletin-post__link">
                                <x-heroicon-o-link class="bulletin-post__link-icon" />
                                {{ Str::limit(parse_url($bulletin->link, PHP_URL_HOST) . parse_url($bulletin->link, PHP_URL_PATH), 40) }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="directory-pagination">
            {{ $bulletins->links() }}
        </div>
    @endif

</div>