@extends('layouts.admin')

@section('title', 'Admin UI · Input & Pagination Test')
@section('page-title', 'Input & Pagination Test')

@section('content')
    <div class="rai-page-heading mb-4">
        <div>
            <h2 class="rai-page-heading__title">Component Test Bench</h2>
            <p class="rai-page-heading__description">Test PIN input behavior and client-side pagination using sample data. No API calls or real PIN verification are performed.</p>
        </div>
        <span class="rai-badge rai-badge--info">Demo only</span>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-5">
            <x-admin-ui::card title="PIN Input" description="Try typing, pasting, using Backspace and arrow keys.">
                <form id="pin-input-test-form" autocomplete="off">
                    <x-admin-ui::pin-input
                        name="demo_pin"
                        label="6-digit transaction PIN"
                        description="Enter any 6 digits. This is only a local UI test."
                        :length="6"
                        :masked="true"
                        required
                    />

                    <div class="d-flex flex-wrap gap-2 mt-4">
                        <x-admin-ui::button-primary type="submit">Test PIN value</x-admin-ui::button-primary>
                        <x-admin-ui::button-outline type="button" id="pin-clear-button">Clear</x-admin-ui::button-outline>
                        <x-admin-ui::button-outline type="button" id="pin-fill-button">Fill sample</x-admin-ui::button-outline>
                    </div>
                </form>

                <div class="mt-3 p-3 rounded border" style="background:var(--rai-surface-muted, #f8f9fa)">
                    <div class="small text-secondary mb-1">Live component state</div>
                    <div id="pin-test-status" class="fw-semibold" aria-live="polite">Waiting for input…</div>
                    <div class="small text-secondary mt-2">Hidden field value: <code id="pin-hidden-value">(empty)</code></div>
                </div>
            </x-admin-ui::card>
        </div>

        <div class="col-12 col-xl-7">
            <x-admin-ui::card title="Client-side Pagination" description="53 sample customers · 8 records per page. Click the page controls to change the visible rows.">
                <div class="rai-table-wrap">
                    <table class="table rai-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Customer</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody id="pagination-test-rows">
                            <tr><td colspan="3" class="text-center text-secondary py-4">Loading sample records…</td></tr>
                        </tbody>
                    </table>
                </div>
                <div id="pagination-test-controls"></div>
                <div class="small text-secondary mt-3" id="pagination-test-state" aria-live="polite">Preparing pagination…</div>
            </x-admin-ui::card>
        </div>
    </div>
@endsection

@push('admin-ui:scripts')
    @vite(['resources/js/pages/input-pagination-test.js'])
@endpush
