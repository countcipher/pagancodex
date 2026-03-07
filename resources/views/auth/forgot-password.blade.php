<x-guest-layout>
    <div class="auth-status"
        style="background-color: transparent; border: none; padding: 0; margin-bottom: 1.5rem; color: #7A6A58;">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="auth-status">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" x-data="{ submitting: false }"
        @submit="submitting = true">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="auth-links">
            <x-primary-button x-bind:disabled="submitting">
                <span x-show="!submitting">{{ __('Email Password Reset Link') }}</span>
                <span x-show="submitting" style="display: none;">
                    <svg style="display:inline; width:1rem; height:1rem; margin-right:0.5rem; animation: spin 1s linear infinite;"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('Sending Link...') }}
                </span>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>