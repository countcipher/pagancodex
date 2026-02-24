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
                    to Pagan Codex — including people who are not logged in — if your profile is listed in the public
                    directory. Only share what you are comfortable making public.
                </div>
            </div>

            <form method="POST" action="{{ route('public-profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_public" class="form-toggle">
                        <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', $profile?->is_public ?? true) ? 'checked' : '' }}>
                        <span>List me in the public directory</span>
                    </label>
                    <p class="form-hint">Uncheck to hide your profile from search results and the member directory.</p>
                </div>

                <hr class="form-divider">

                {{-- Profile Photo --}}
                <div class="form-group">
                    <x-input-label for="avatar" :value="__('Profile Photo')" />

                    <div class="avatar-upload">
                        <img id="avatar-preview-img"
                            src="{{ $profile?->avatar_path ? Storage::url($profile->avatar_path) : '' }}"
                            alt="Profile photo preview" class="avatar-upload__preview"
                            style="{{ $profile?->avatar_path ? '' : 'display: none;' }}">

                        <label for="avatar" class="btn btn--secondary">Choose File</label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="sr-only">
                    </div>

                    <p class="form-hint">JPG, PNG, or GIF. Max 2MB. Recommended: square, at least 200×200px.</p>
                    <x-input-error :messages="$errors->get('avatar')" />
                </div>

                {{-- Tradition --}}
                <div class="form-group">
                    <x-input-label for="tradition" :value="__('Tradition')" />
                    <x-text-input id="tradition" type="text" name="tradition" :value="old('tradition', $profile?->tradition)" placeholder="e.g. Wicca, Asatru, Druidry…" />
                    <x-input-error :messages="$errors->get('tradition')" />
                </div>

                {{-- Clergy --}}
                <div class="form-group">
                    <x-input-label :value="__('Are you legal clergy?')" />
                    <div class="form-radio-group">
                        <label class="form-radio">
                            <input type="radio" name="clergy" value="1" {{ old('clergy', $profile?->clergy) == '1' ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>
                        <label class="form-radio">
                            <input type="radio" name="clergy" value="0" {{ old('clergy', $profile?->clergy ?? 0) == '0' ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('clergy')" />
                </div>

                {{-- Bio --}}
                <div class="form-group">
                    <x-input-label for="bio" :value="__('Bio')" />
                    <textarea id="bio" name="bio" class="form-input form-input--textarea" rows="4"
                        placeholder="Tell the community a little about yourself…">{{ old('bio', $profile?->bio) }}</textarea>
                    <x-input-error :messages="$errors->get('bio')" />
                </div>

                {{-- Location --}}
                <x-location-select :country="$profile?->country" :stateProvince="$profile?->state_province"
                    :city="$profile?->city" :allowEmpty="true" />

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

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Save Profile</button>
                </div>
            </form>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        (function () {
            // Location logic has been extracted to Alpine.js in x-location-select component

            // Avatar live preview
            const avatarInput = document.getElementById('avatar');
            const avatarPreviewImg = document.getElementById('avatar-preview-img');

            if (avatarInput && avatarPreviewImg) {
                avatarInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            avatarPreviewImg.src = e.target.result;
                            avatarPreviewImg.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        })();
    </script>
@endpush