@extends('layouts.dashboard')

@section('title', 'Create Group')

@section('content')

    <div class="page-header">
        <h1>Create Group</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-create-group">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-create-group">Register a New Group</h2>
            </header>

            <div class="notice notice--warning" role="note">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="notice__icon"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <strong>Privacy notice:</strong> Any information you enter here will be visible to <em>all visitors</em>
                    to Pagan Codex — including people who are not logged in — if your group is listed in the public
                    directory. Only share what you are comfortable making public.
                </div>
            </div>

            <form method="POST" action="{{ route('groups.store') }}">
                @csrf

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_public" class="form-toggle">
                        <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}>
                        <span>List this group in the public directory</span>
                    </label>
                    <p class="form-hint">Uncheck to hide this group from search results and the directory. You can still use
                        platform tools.</p>
                </div>

                <hr class="form-divider">

                {{-- Group Name --}}
                <div class="form-group">
                    <x-input-label for="name" :value="__('Group Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        placeholder="e.g. Silver Circle Coven" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                {{-- Tradition --}}
                <div class="form-group">
                    <x-input-label for="tradition" :value="__('Tradition')" />
                    <x-text-input id="tradition" type="text" name="tradition" :value="old('tradition')"
                        placeholder="e.g. Wicca, Asatru, Eclectic…" />
                    <p class="form-hint">Optional. Leave blank if not applicable or if you are an eclectic/general group.
                    </p>
                    <x-input-error :messages="$errors->get('tradition')" />
                </div>

                {{-- Clergy --}}
                <div class="form-group">
                    <x-input-label :value="__('Does this group have legal clergy?')" />
                    <div class="form-radio-group">
                        <label class="form-radio">
                            <input type="radio" name="has_clergy" value="1" {{ old('has_clergy') == '1' ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>
                        <label class="form-radio">
                            <input type="radio" name="has_clergy" value="0" {{ old('has_clergy', 0) == '0' ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('has_clergy')" />
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" class="form-input form-input--textarea" rows="6" required
                        placeholder="Describe your group, its focus, requirements to join, etc...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <hr class="form-divider">

                {{-- Location (Required) --}}
                <div class="form-group">
                    <p class="form-section-subheading" style="margin-bottom: $spacing-md;">Where is this group located?
                    </p>
                </div>

                <x-location-select :allowEmpty="false" />

                <hr class="form-divider">
                <p class="form-section-subheading">Contact & Social Links (Optional)</p>

                {{-- Public Email --}}
                <div class="form-group">
                    <x-input-label for="contact_email" :value="__('Public Contact Email')" />
                    <x-text-input id="contact_email" type="email" name="contact_email" :value="old('contact_email')"
                        placeholder="contact@example.com" />
                    <p class="form-hint">This email will be visible on the group's public profile.</p>
                    <x-input-error :messages="$errors->get('contact_email')" />
                </div>

                {{-- Phone Number --}}
                <div class="form-group">
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number')"
                        placeholder="Optional — only share if you're comfortable" />
                    <p class="form-hint">This phone number will be visible on the group's public profile.</p>
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>

                {{-- Website --}}
                <div class="form-group">
                    <x-input-label for="website" :value="__('Website')" />
                    <x-text-input id="website" type="url" name="website" :value="old('website')"
                        placeholder="https://yoursite.com" />
                    <x-input-error :messages="$errors->get('website')" />
                </div>

                {{-- Facebook --}}
                <div class="form-group">
                    <x-input-label for="facebook_url" :value="__('Facebook')" />
                    <x-text-input id="facebook_url" type="url" name="facebook_url" :value="old('facebook_url')"
                        placeholder="https://facebook.com/yourgroup" />
                    <x-input-error :messages="$errors->get('facebook_url')" />
                </div>

                {{-- Instagram --}}
                <div class="form-group">
                    <x-input-label for="instagram_url" :value="__('Instagram')" />
                    <x-text-input id="instagram_url" type="url" name="instagram_url" :value="old('instagram_url')"
                        placeholder="https://instagram.com/yourgroup" />
                    <x-input-error :messages="$errors->get('instagram_url')" />
                </div>

                {{-- X / Twitter --}}
                <div class="form-group">
                    <x-input-label for="x_url" :value="__('X (formerly Twitter)')" />
                    <x-text-input id="x_url" type="url" name="x_url" :value="old('x_url')"
                        placeholder="https://x.com/yourgroup" />
                    <x-input-error :messages="$errors->get('x_url')" />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Create Group</button>
                    <a href="{{ route('dashboard') }}" class="btn btn--secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

@endsection