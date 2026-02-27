<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — Pagan Codex</title>
    <meta name="description"
        content="@yield('description', 'Your directory of pagan people, groups, events, and resources.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @stack('head')
</head>

<body>

    {{-- Skip to main content (a11y) --}}
    <a href="#main-content" class="skip-link">Skip to main content</a>

    {{-- Toast notifications --}}
    <x-toast :status="session('status')" />

    {{-- ==========================================
    TOP NAVIGATION
    Public-facing: visible to all users
    =========================================== --}}
    <header role="banner">
        <nav class="site-nav" aria-label="Primary navigation">
            <a href="{{ url('/') }}" class="site-nav__logo" aria-label="Pagan Codex — Home">
                Pagan<span>Codex</span>
            </a>

            {{-- Mobile: hamburger toggle --}}
            <button class="site-nav__toggle" id="nav-toggle" aria-controls="nav-links" aria-expanded="false"
                aria-label="Toggle navigation menu">
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
                <span class="hamburger-line" aria-hidden="true"></span>
            </button>

            <ul class="site-nav__links" id="nav-links" role="list">
                <li><a href="{{ route('directory') }}">Directory</a></li>
                <li><a href="{{ route('events.browse') }}">Events</a></li>
                <li><a href="#">Groups</a></li>
                <li><a href="#">Shops</a></li>
                @auth
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </a>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Log In</a></li>
                    <li><a href="{{ route('register') }}" class="nav-btn">Join Free</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <div class="dashboard-wrapper">

        {{-- ==========================================
        LEFT SIDEBAR
        Authenticated user actions only
        =========================================== --}}
        @auth
            <aside class="sidebar" id="sidebar" aria-label="Dashboard navigation">
                <div class="sidebar__header">
                    <p class="sidebar__username">{{ auth()->user()->name ?? 'Your Name' }}</p>
                    <p class="sidebar__role">Member</p>
                </div>

                <div class="sidebar__section">
                    <p class="sidebar__section-label">My Profile</p>
                    <ul class="sidebar__nav" role="list">
                        <li class="sidebar__item">
                            <a href="{{route('dashboard')}}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                                <x-heroicon-o-squares-2x2 class="nav-icon" aria-hidden="true" />
                                Overview
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a href="{{ route('public-profile.edit') }}"
                                class="{{ request()->routeIs('public-profile.edit') ? 'active' : '' }}">
                                <x-heroicon-o-user class="nav-icon" aria-hidden="true" />
                                Public Profile
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a href="{{ route('profile.edit') }}"
                                class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                <x-heroicon-o-cog-6-tooth class="nav-icon" aria-hidden="true" />
                                Account Settings
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebar__section">
                    <p class="sidebar__section-label">My Listings</p>
                    <ul class="sidebar__nav" role="list">
                        <li class="sidebar__item">
                            <a href="{{ route('events.index') }}"
                                class="{{ request()->routeIs('events.*') ? 'active' : '' }}">
                                <x-heroicon-o-calendar-days class="nav-icon" aria-hidden="true" />
                                Events
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a href="{{ route('groups.index') }}"
                                class="{{ request()->routeIs('groups.*') ? 'active' : '' }}">
                                <x-heroicon-o-user-group class="nav-icon" aria-hidden="true" />
                                Groups
                            </a>
                        </li>
                        <li class="sidebar__item">
                            <a href="{{ route('shops.index') }}"
                                class="{{ request()->routeIs('shops.*') ? 'active' : '' }}">
                                <x-heroicon-o-shopping-bag class="nav-icon" aria-hidden="true" />
                                Shops
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Overlay for mobile sidebar --}}
            <div class="sidebar-overlay" id="sidebar-overlay" aria-hidden="true"></div>
        @endauth

        {{-- ==========================================
        MAIN CONTENT
        =========================================== --}}
        <main class="dashboard-content" id="main-content" tabindex="-1" @guest style="margin-left: 0;" @endguest>

            @auth
                {{-- Mobile-only bar: sidebar toggle --}}
                <div class="mobile-bar" aria-hidden="true">
                    <button class="mobile-bar__toggle" id="sidebar-toggle" aria-controls="sidebar" aria-expanded="false"
                        aria-label="Open dashboard menu">
                        <x-heroicon-o-bars-3 class="nav-icon" aria-hidden="true" />
                        Menu
                    </button>
                </div>
            @endauth

            {{ $slot ?? '' }}
            @yield('content')
        </main>

    </div>{{-- /.dashboard-wrapper --}}

    {{-- ==========================================
    SIDEBAR / NAV TOGGLE SCRIPT
    =========================================== --}}
    <script>
        (function () {
            const navToggle = document.getElementById('nav-toggle');
            const navLinks = document.getElementById('nav-links');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            // Top nav toggle (mobile)
            if (navToggle && navLinks) {
                navToggle.addEventListener('click', function () {
                    const isOpen = navLinks.classList.toggle('site-nav__links--open');
                    navToggle.setAttribute('aria-expanded', isOpen);
                });
            }

            // Sidebar toggle
            const sidebarToggle = document.getElementById('sidebar-toggle');

            function openSidebar() {
                sidebar.classList.add('sidebar--open');
                overlay.classList.add('sidebar-overlay--visible');
                sidebarToggle && sidebarToggle.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                sidebar.classList.remove('sidebar--open');
                overlay.classList.remove('sidebar-overlay--visible');
                sidebarToggle && sidebarToggle.setAttribute('aria-expanded', 'false');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', openSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        })();
    </script>

    @stack('scripts')

</body>

</html>