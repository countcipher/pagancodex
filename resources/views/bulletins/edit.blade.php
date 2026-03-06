@extends('layouts.dashboard')

@section('title', 'Edit Bulletin')

@section('content')

    <div class="page-header">
        <h1>Edit Bulletin</h1>
    </div>

    <section class="dashboard-panel">
        <div class="dashboard-panel__body">

            <form method="POST" action="{{ route('bulletins.update', $bulletin) }}"
                x-data="{ body: '{{ addslashes($bulletin->body) }}', link: '{{ $bulletin->link ?? '' }}' }">
                @csrf
                @method('PUT')

                {{-- Body --}}
                <div class="form-group">
                    <x-input-label for="body" :value="__('Bulletin Text')" />
                    <textarea id="body" name="body" x-model="body" maxlength="200" class="form-input form-input--textarea"
                        rows="3" required>{{ old('body', $bulletin->body) }}</textarea>
                    <span class="bulletin-form-card__counter"
                        :class="{ 'bulletin-form-card__counter--warn': body.length > 180 }"
                        x-text="body.length + ' / 200'"></span>
                    <x-input-error :messages="$errors->get('body')" />
                </div>

                {{-- Link --}}
                <div class="form-group">
                    <x-input-label for="link" :value="__('Link (Optional)')" />
                    <x-text-input id="link" type="url" name="link" :value="old('link', $bulletin->link)"
                        placeholder="https://..." />
                    <x-input-error :messages="$errors->get('link')" />
                </div>

                <div class="form-actions">
                    <a href="{{ route('bulletins.index') }}" class="btn btn--secondary">Cancel</a>
                    <button type="submit" class="btn btn--primary">Update Bulletin</button>
                </div>
            </form>

        </div>
    </section>

@endsection