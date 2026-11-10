@php
    $pageTitle = trim($__env->yieldContent('title')) ?: config('app.name', 'Laravel');
    $headerTitle = trim($__env->yieldContent('header_title')) ?: $pageTitle;

    $profile = data_get($headerData ?? [], 'profile', []);
    $cardData = data_get($headerData ?? [], 'cards', []);

    $user = auth()->user();
    $defaultProfileName = $user?->name ?? 'Administrator';
@endphp

<x-admin-ui::layout :title="$pageTitle">
    <x-slot:sidebar>
        <x-admin-ui::sidebar :sections="$menu ?? []" />
    </x-slot:sidebar>

    <x-slot:header>
        <x-admin-ui::header
            :title="$headerTitle"
            :subtitle="data_get($headerData ?? [], 'subtitle')"
            :profile-name="data_get($profile, 'name', $defaultProfileName)"
            :profile-role="data_get($profile, 'role', 'User')"
            :profile-initials="data_get($profile, 'initials', 'AD')"
            :profile-avatar="data_get($profile, 'avatar')"
            :card-data="$cardData"
        />
    </x-slot:header>

    @yield('content')

    @hasSection('footer')
        <x-slot:footer>
            @yield('footer')
        </x-slot:footer>
    @endif
</x-admin-ui::layout>
