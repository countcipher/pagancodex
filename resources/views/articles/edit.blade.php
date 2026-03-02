@extends('layouts.dashboard')

@section('title', 'Edit Article')

@section('content')

    <div class="page-header">
        <h1>Edit Article</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-edit-article">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-edit-article">Update Article</h2>
            </header>

            <form method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_published" class="form-toggle">
                        <input id="is_published" type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                        <span>Publish this article</span>
                    </label>
                    <p class="form-hint">Uncheck to unpublish this article and revert it to a Draft.</p>
                </div>

                <hr class="form-divider">

                {{-- Title --}}
                <div class="form-group">
                    <x-input-label for="title" :value="__('Article Title')" />
                    <x-text-input id="title" type="text" name="title" :value="old('title', $article->title)" required
                        autofocus />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <x-input-label for="description" :value="__('Short Description')" />
                    <x-text-input id="description" type="text" name="description" :value="old('description', $article->description)" required />
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                {{-- Featured Image --}}
                <div class="form-group">
                    <x-input-label for="image" :value="__('Featured Image')" />

                    <div x-data="{ 
                                                            previewUrl: '{{ $article->image_path ? Storage::url($article->image_path) : '' }}',
                                                            fileChosen(event) {
                                                                const file = event.target.files[0];
                                                                if (file) {
                                                                    this.previewUrl = URL.createObjectURL(file);
                                                                }
                                                            }
                                                        }">
                        <!-- Featured Image Preview Banner -->
                        <img id="image-preview-img" :src="previewUrl" alt="Featured image preview" x-show="previewUrl"
                            class="article-image-preview" style="display: {{ $article->image_path ? 'block' : 'none' }};">

                        <div>
                            <label for="image" class="btn btn--secondary">Choose New Image...</label>
                            <input id="image" type="file" name="image" accept="image/*" class="sr-only"
                                @change="fileChosen">
                        </div>
                    </div>

                    <p class="form-hint" style="margin-top: 0.5rem">Leave blank to keep your current featured image. Must be
                        smaller than 2MB.</p>
                    <x-input-error :messages="$errors->get('image')" />
                </div>

                {{-- Content --}}
                <div class="form-group">
                    <x-input-label for="content" :value="__('Article Content')" />
                    <textarea id="content" name="content" rows="15"
                        class="form-textarea">{{ old('content', $article->content) }}</textarea>
                    <x-input-error :messages="$errors->get('content')" />
                </div>

                <div class="form-actions">
                    <a href="{{ route('articles.index') }}" class="btn btn--secondary">Cancel</a>
                    <x-primary-button>
                        {{ __('Update Article') }}
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