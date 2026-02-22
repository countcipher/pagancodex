<x-guest-layout>
    <div class="auth-status" style="background-color: transparent; border: none; padding: 0; margin-bottom: 1.5rem; color: #7A6A58;">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-status">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="auth-links" style="justify-content: space-between;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="btn-link">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
