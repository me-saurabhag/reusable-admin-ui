@extends('layouts.admin')

@section('title', 'Admin UI · Right Offcanvas Demo')
@section('page-title', 'Right Offcanvas Demo')

@section('content')
    <div class="rai-page-heading">
        <div>
            <h2 class="rai-page-heading__title">Right Offcanvas</h2>
            <p class="rai-page-heading__description">A shared form drawer with host-owned submission, validation and persistence.</p>
        </div>
        <span class="rai-badge rai-badge--info">Interactive demo</span>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-7">
            <x-admin-ui::card title="Customer form drawer" description="Open the drawer, edit the sample fields and submit. No API request or database write is performed.">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="rai-btn rai-btn-primary px-3" data-bs-toggle="offcanvas" data-bs-target="#customer-demo-offcanvas" aria-controls="customer-demo-offcanvas">
                        <span class="me-2" aria-hidden="true">＋</span> Open customer form
                    </button>
                    <button type="button" class="rai-btn rai-btn-outline px-3" id="offcanvas-reset-demo">Reset demo</button>
                </div>
                <div class="mt-4 p-3 rounded-3" style="background:var(--rai-surface-muted); border:1px solid var(--rai-border)">
                    <div class="small fw-semibold mb-1">What this demo verifies</div>
                    <ul class="small text-secondary mb-0 ps-3">
                        <li>Shared header, scrollable body and fixed footer.</li>
                        <li>Native required/email validation before submit.</li>
                        <li>FormData is passed to the Host through a custom event.</li>
                        <li>Submit loading state, success feedback and close behavior.</li>
                        <li>Responsive width and Bootstrap backdrop/keyboard behavior.</li>
                    </ul>
                </div>
            </x-admin-ui::card>
        </div>

        <div class="col-12 col-xl-5">
            <x-admin-ui::card title="Last submit payload" description="The values received by the Host-side demo listener.">
                <pre id="offcanvas-demo-payload" class="small mb-0 p-3 rounded-3" style="min-height:150px; white-space:pre-wrap; overflow-wrap:anywhere; background:var(--rai-surface-muted); color:var(--rai-text)">No submission yet.</pre>
                <div id="offcanvas-demo-status" class="small text-secondary mt-3" role="status" aria-live="polite">Waiting for a demo submission.</div>
            </x-admin-ui::card>
        </div>
    </div>

    <x-admin-ui::offcanvas
        id="customer-demo-offcanvas"
        title="Add customer"
        subtitle="Enter the customer's basic information. This is a local UI demonstration."
        width="560px"
        submit-label="Save customer"
        cancel-label="Cancel"
    >
        <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--rai-border)">
            <div class="rai-offcanvas-demo-avatar">JD</div>
            <div>
                <div class="fw-semibold">New customer profile</div>
                <div class="small text-secondary">Customer details</div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-12">
                <x-admin-ui::input name="name" label="Full name" placeholder="e.g. John Doe" required />
            </div>
            <div class="col-12">
                <x-admin-ui::input name="email" type="email" label="Email address" placeholder="john@example.com" required />
            </div>
            <div class="col-12 col-md-6">
                <x-admin-ui::input name="phone" type="tel" label="Phone number" placeholder="+1 555 0100" />
            </div>
            <div class="col-12 col-md-6">
                <x-admin-ui::select name="status" label="Customer status">
                    <option value="active" selected>Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </x-admin-ui::select>
            </div>
            <div class="col-12">
                <x-admin-ui::textarea name="notes" label="Internal notes" rows="4" placeholder="Add any useful context…" />
            </div>
            <div class="col-12">
                <label class="d-flex align-items-start gap-2 small" style="color:var(--rai-text-secondary)">
                    <input class="form-check-input mt-1" type="checkbox" name="send_welcome" value="1">
                    <span>Send a welcome message after the customer is created.</span>
                </label>
            </div>
        </div>
    </x-admin-ui::offcanvas>
@endsection

@push('admin-ui:scripts')
    @vite(['resources/js/pages/offcanvas-demo.js'])
@endpush

