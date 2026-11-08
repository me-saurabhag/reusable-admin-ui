@extends('layouts.admin')

@section('title', $pageTitle)
@section('page-title', $pageTitle)

@section('content')
<x-admin-ui::stack gap="3">
    <x-admin-ui::heading level="3">
        Customer Details
    </x-admin-ui::heading>

    <x-admin-ui::input
        name="name"
        label="Customer Name"
    />

    <x-admin-ui::button variant="outline">
        Save Changes
    </x-admin-ui::button>
</x-admin-ui::stack>
@endsection
