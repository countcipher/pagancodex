@props(['status' => null])

@php
    $messages = [
        'profile-updated' => 'Profile information saved.',
        'public-profile-updated' => 'Public profile saved.',
        'password-updated' => 'Password updated successfully.',
        'event-created' => 'Your event has been successfully created.',
    ];

    $message = $status ? ($messages[$status] ?? null) : null;
@endphp

@if ($message)
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition:enter="toast-enter" x-transition:enter-start="toast-enter-start"
        x-transition:enter-end="toast-enter-end" x-transition:leave="toast-leave"
        x-transition:leave-start="toast-leave-start" x-transition:leave-end="toast-leave-end" class="toast toast--success"
        role="status" aria-live="polite">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="toast__icon"
            aria-hidden="true">
            <path fill-rule="evenodd"
                d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                clip-rule="evenodd" />
        </svg>
        <span>{{ $message }}</span>
        <button @click="show = false" class="toast__close" aria-label="Dismiss">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path
                    d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
            </svg>
        </button>
    </div>
@endif