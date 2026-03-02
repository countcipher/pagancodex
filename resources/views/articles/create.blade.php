@extends('layouts.dashboard')

@section('title', 'Write Article')

@section('content')

    <div class="page-header">
        <h1>Write Article</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-create-article">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-create-article">Draft a New Article</h2>
            </header>

            <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_published" class="form-toggle">
                        <input id="is_published" type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish this article immediately</span>
                    </label>
                    <p class="form-hint">Leave unchecked to save as a Draft. Drafts are not visible to anyone else.</p>
                </div>

                <hr class="form-divider">

                {{-- Title --}}
                <div class="form-group">
                    <x-input-label for="title" :value="__('Article Title')" />
                    <x-text-input id="title" type="text" name="title" :value="old('title')" required autofocus
                        placeholder="e.g. A Beginner's Guide to Lithomancy" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <x-input-label for="description" :value="__('Short Description')" />
                    <x-text-input id="description" type="text" name="description" :value="old('description')" required
                        placeholder="A 1-2 sentence hook to display on the article preview card." />
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                {{-- Featured Image --}}
                <div class="form-group">
                    <x-input-label for="image" :value="__('Featured Image')" />

                    <div x-data="{ 
                                                        previewUrl: '{{ old('image') ? '' : '' }}',
                                                        fileChosen(event) {
                                                            const file = event.target.files[0];
                                                            if (file) {
                                                                this.previewUrl = URL.createObjectURL(file);
                                                            }
                                                        }
                                                    }">
                        <!-- Featured Image Preview Banner -->
                        <img id="image-preview-img" :src="previewUrl" alt="Featured image preview" x-show="previewUrl"
                            class="article-image-preview" style="display: none;">

                        <div>
                            <label for="image" class="btn btn--secondary">Choose File</label>
                            <input id="image" type="file" name="image" accept="image/*" class="sr-only" required
                                @change="fileChosen">
                        </div>
                    </div>

                    <p class="form-hint" style="margin-top: 0.5rem">This image will appear at the top of the article. Must
                        be smaller than 2MB.</p>
                    <x-input-error :messages="$errors->get('image')" />
                </div>

                {{-- Content --}}
                <div class="form-group">
                    <x-input-label for="content" :value="__('Article Content')" />
                    <textarea id="content" name="content" rows="15" class="form-textarea"
                        placeholder="Write your article here...">{{ old('content') }}</textarea>
                    <x-input-error :messages="$errors->get('content')" />
                </div>

                <div class="form-actions">
                    <a href="{{ route('articles.index') }}" class="btn btn--secondary">Cancel</a>
                    <x-primary-button>
                        {{ __('Save Article') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </section>

    {{-- Load TinyMCE from public/vendor --}}
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#content',
            license_key: 'gpl',
            height: 500,
            menubar: false,
            plugins: 'lists link emoticons wordcount',
            toolbar: 'undo redo | blocks | ' +
                'bold italic strikethrough forecolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'link emoticons | removeformat',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save(); // keeps the hidden textarea in sync
                });
            }
        });
    </script>
@endsection