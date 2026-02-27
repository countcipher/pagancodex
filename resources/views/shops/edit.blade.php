@extends('layouts.dashboard')

@section('title', 'Edit Shop')

@section('content')

    <div class="page-header">
        <h1>Edit Shop</h1>
    </div>

    <section class="dashboard-panel" aria-labelledby="panel-edit-shop">
        <div class="dashboard-panel__body">
            <header class="form-section-header">
                <h2 id="panel-edit-shop">Edit: {{ $shop->name }}</h2>
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
                    to Pagan Codex — including people who are not logged in — if your shop is listed in the public
                    directory. Only share what you are comfortable making public.
                </div>
            </div>

            <form method="POST" action="{{ route('shops.update', $shop) }}">
                @csrf
                @method('PUT')

                {{-- Visibility --}}
                <div class="form-group">
                    <label for="is_public" class="form-toggle">
                        <input id="is_public" type="checkbox" name="is_public" value="1" {{ old('is_public', $shop->is_public) ? 'checked' : '' }}>
                        <span>List this shop in the public directory</span>
                    </label>
                    <p class="form-hint">Uncheck to hide this shop from search results and the directory. You can still use
                        platform tools.</p>
                </div>

                <hr class="form-divider">

                {{-- Shop Name --}}
                <div class="form-group">
                    <x-input-label for="name" :value="__('Shop Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name', $shop->name)" required autofocus
                        placeholder="e.g. The Apothecary" />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                {{-- Description --}}
                <div class="form-group">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" class="form-input form-input--textarea" rows="6" required
                        placeholder="Describe your shop, what you sell, your specialties, etc...">{{ old('description', $shop->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <hr class="form-divider">

                {{-- Location (Required) --}}
                <div class="form-group">
                    <p class="form-section-subheading">Where is this shop located?
                    </p>
                </div>

                <x-location-select :allowEmpty="false" :country="old('country', $shop->country)"
                    :state-province="old('state_province', $shop->state_province)" :city="old('city', $shop->city)" />

                <hr class="form-divider">
                <p class="form-section-subheading">Operating Hours</p>
                <div class="form-group">
                    <p class="form-hint">Enter your hours of operation, e.g. "9am - 5pm", "By
                        Appointment", or "Closed".</p>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_monday" :value="__('Monday')" />
                    <x-text-input id="hours_monday" type="text" name="hours_monday" :value="old('hours_monday', $shop->hours_monday)" placeholder="e.g. 9am - 5pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_monday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_tuesday" :value="__('Tuesday')" />
                    <x-text-input id="hours_tuesday" type="text" name="hours_tuesday" :value="old('hours_tuesday', $shop->hours_tuesday)" placeholder="e.g. 9am - 5pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_tuesday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_wednesday" :value="__('Wednesday')" />
                    <x-text-input id="hours_wednesday" type="text" name="hours_wednesday" :value="old('hours_wednesday', $shop->hours_wednesday)" placeholder="e.g. 9am - 5pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_wednesday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_thursday" :value="__('Thursday')" />
                    <x-text-input id="hours_thursday" type="text" name="hours_thursday" :value="old('hours_thursday', $shop->hours_thursday)" placeholder="e.g. 9am - 5pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_thursday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_friday" :value="__('Friday')" />
                    <x-text-input id="hours_friday" type="text" name="hours_friday" :value="old('hours_friday', $shop->hours_friday)" placeholder="e.g. 9am - 5pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_friday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_saturday" :value="__('Saturday')" />
                    <x-text-input id="hours_saturday" type="text" name="hours_saturday" :value="old('hours_saturday', $shop->hours_saturday)" placeholder="e.g. 10am - 4pm" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_saturday')" /></div>
                </div>

                <div class="hours-grid">
                    <x-input-label for="hours_sunday" :value="__('Sunday')" />
                    <x-text-input id="hours_sunday" type="text" name="hours_sunday" :value="old('hours_sunday', $shop->hours_sunday)" placeholder="e.g. Closed" />
                    <div class="hours-grid__error"><x-input-error :messages="$errors->get('hours_sunday')" /></div>
                </div>

                <hr class="form-divider">
                <p class="form-section-subheading">Contact & Social Links (Optional)</p>

                {{-- Public Email --}}
                <div class="form-group">
                    <x-input-label for="contact_email" :value="__('Public Contact Email')" />
                    <x-text-input id="contact_email" type="email" name="contact_email" :value="old('contact_email', $shop->contact_email)" placeholder="hello@example.com" />
                    <p class="form-hint">This email will be visible on the shop's public profile.</p>
                    <x-input-error :messages="$errors->get('contact_email')" />
                </div>

                {{-- Phone Number --}}
                <div class="form-group">
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" type="text" name="phone_number" :value="old('phone_number', $shop->phone_number)" placeholder="Optional — only share if you're comfortable" />
                    <p class="form-hint">This phone number will be visible on the shop's public profile.</p>
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>

                {{-- Website --}}
                <div class="form-group">
                    <x-input-label for="website" :value="__('Website')" />
                    <x-text-input id="website" type="url" name="website" :value="old('website', $shop->website)"
                        placeholder="https://yoursite.com" />
                    <x-input-error :messages="$errors->get('website')" />
                </div>

                {{-- Facebook --}}
                <div class="form-group">
                    <x-input-label for="facebook_url" :value="__('Facebook')" />
                    <x-text-input id="facebook_url" type="url" name="facebook_url" :value="old('facebook_url', $shop->facebook_url)" placeholder="https://facebook.com/yourshop" />
                    <x-input-error :messages="$errors->get('facebook_url')" />
                </div>

                {{-- Instagram --}}
                <div class="form-group">
                    <x-input-label for="instagram_url" :value="__('Instagram')" />
                    <x-text-input id="instagram_url" type="url" name="instagram_url" :value="old('instagram_url', $shop->instagram_url)" placeholder="https://instagram.com/yourshop" />
                    <x-input-error :messages="$errors->get('instagram_url')" />
                </div>

                {{-- X / Twitter --}}
                <div class="form-group">
                    <x-input-label for="x_url" :value="__('X (formerly Twitter)')" />
                    <x-text-input id="x_url" type="url" name="x_url" :value="old('x_url', $shop->x_url)"
                        placeholder="https://x.com/yourshop" />
                    <x-input-error :messages="$errors->get('x_url')" />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn--primary">Save Changes</button>
                    <a href="{{ route('shops.index') }}" class="btn btn--secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>

@endsection