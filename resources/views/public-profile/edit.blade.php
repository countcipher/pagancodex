@extends('layouts.dashboard')

@section('title', 'Public Profile')

@section('content')

    <div class="page-header">
        <h1>Public Profile</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-public-profile">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2>Your Public Profile</h2>
                <p>This information may be visible to other members of the Pagan Codex community. Fill in only what you're
                    comfortable sharing.</p>
            </header>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="form-saved">Profile saved.</p>
            @endif

            <form method="POST" action="{{ route('public-profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Profile Photo --}}
                <div class="form-group">
                    <x-input-label for="avatar" :value="__('Profile Photo')" />

                    @if ($profile?->avatar_path)
                        <div class="avatar-preview">
                            <img src="{{ Storage::url($profile->avatar_path) }}" alt="Current profile photo">
                        </div>
                    @endif

                    <input id="avatar" type="file" name="avatar" accept="image/*" class="form-file-input">
                    <p class="form-hint">JPG, PNG, or GIF. Max 2MB. Recommended: square, at least 200×200px.</p>
                    <x-input-error :messages="$errors->get('avatar')" />
                </div>

                {{-- Tradition --}}
                <div class="form-group">
                    <x-input-label for="tradition" :value="__('Tradition')" />
                    <x-text-input id="tradition" type="text" name="tradition" :value="old('tradition', $profile?->tradition)" placeholder="e.g. Wicca, Asatru, Druidry…" />
                    <x-input-error :messages="$errors->get('tradition')" />
                </div>

                {{-- Bio --}}
                <div class="form-group">
                    <x-input-label for="bio" :value="__('Bio')" />
                    <textarea id="bio" name="bio" class="form-input form-input--textarea" rows="4"
                        placeholder="Tell the community a little about yourself…">{{ old('bio', $profile?->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" />
                </div>

                {{-- Location --}}
                <div class="form-group">
                    <x-input-label for="location" :value="__('Location')" />
                    <x-text-input id="location" type="text" name="location" :value="old('location', $profile?->location)"
                        placeholder="e.g. Salem, MA or Pacific Northwest" />
                    <x-input-error :messages="$errors->get('location')" />
                </div>

                {{-- Website --}}
                <div class="form-group">
                    <x-input-label for="website" :value="__('Website')" />
                    <x-text-input id="website" type="url" name="website" :value="old('website', $profile?->website)"
                        placeholder="https://yoursite.com" />
                    <x-input-error :messages="$errors->get('website')" />
                </div>

                <hr class="form-divider">
                <p class="form-section-subheading">Social & Contact</p>

                {{-- Facebook --}}
                <div class="form-group">
                    <x-input-label for="facebook_url" :value="__('Facebook')" />
                    <x-text-input id="facebook_url" type="url" name="facebook_url" :value="old('facebook_url', $profile?->facebook_url)" placeholder="https://facebook.com/yourprofile" />
                    <x-input-error :messages="$errors->get('facebook_url')" />
                </div>

                {{-- Instagram --}}
                <div class="form-group">
                    <x-input-label for="instagram_url" :value="__('Instagram')" />
                    <x-text-input id="instagram_url" type="url" name="instagram_url" :value="old('instagram_url', $profile?->instagram_url)" placeholder="https://instagram.com/yourhandle" />
                    <x-input-error :messages="$errors->get('instagram_url')" />
                </div>

                {{-- X / Twitter --}}
                <div class="form-group">
                    <x-input-label for="x_url" :value="__('X (formerly Twitter)')" />
                    <x-text-input id="x_url" type="url" name="x_url" :value="old('x_url', $profile?->x_url)"
                        placeholder="https://x.com/yourhandle" />
                    <x-input-error :messages="$errors->get('x_url')" />
                </div>

                {{-- Public Email --}}
                <div class="form-group">
                    <x-input-label for="public_email" :value="__('Public Email')" />
                    <x-text-input id="public_email" type="email" name="public_email" :value="old('public_email', $profile?->public_email)" placeholder="contact@example.com" />
                    <p class="form-hint">This email will be visible on your public profile.</p>
                    <x-input-error :messages="$errors->get('public_email')" />
                </div>

                {{-- Phone --}}
                <div class="form-group">
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number', $profile?->phone_number)" placeholder="Optional — only share if you're comfortable" />
                    <p class="form-hint">This phone number will be visible on your public profile.</p>
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>

                <hr class="form-divider">

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_public" class="form-toggle">
                        <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', $profile?->is_public ?? true) ? 'checked' : '' }}>
                        <span>List me in the public directory</span>
                    </label>
                    <p class="form-hint">Uncheck to hide your profile from search results and the member directory.</p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Save Profile</button>
                </div>
            </form>
        </div>
    </section>

@endsection