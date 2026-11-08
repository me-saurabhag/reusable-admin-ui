@php
    $layoutTitle = trim($__env->yieldContent('title', config('app.name', 'Admin')));
    $pageTitle = trim($__env->yieldContent('page-title', $layoutTitle));
@endphp

<x-admin-ui::layout :title="$layoutTitle">
    <x-slot:sidebar>
        <x-admin-ui::sidebar :sections="$menu" />
    </x-slot:sidebar>

    <x-slot:header>
        <x-admin-ui::header
            :title="$pageTitle"
            subtitle=" "
            :profile-name="$headerData['profile']['name'] ?? 'Admin'"
            :profile-role="$headerData['profile']['role'] ?? 'Admin'"
            :profile-initials="$headerData['profile']['initials'] ?? 'AD'"
            :profile-avatar="$headerData['profile']['avatar'] ?? null"
            :card-data="$headerData['cards'] ?? []"
        />
    </x-slot:header>

    @yield('content')
</x-admin-ui::layout>
