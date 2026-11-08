<x-admin-ui::layout title="Form Inputs">
    <div class="rai-inputs-page">
        <div class="rai-inputs-page__header">
            <div>
                <div class="rai-inputs-page__eyebrow">UI COMPONENTS / FORMS</div>
                <h1 class="rai-inputs-page__title">Form Inputs</h1>
                <p class="rai-inputs-page__description">Consistent text fields, selects and textareas with accessible labels, validation and helpful descriptions.</p>
            </div>
            <span class="rai-inputs-page__version">Form controls</span>
        </div>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Default Inputs</h2><p>Common input types for everyday forms.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="demo_name" label="Full Name" placeholder="Enter your full name" />
                <x-admin-ui::input name="demo_email" type="email" label="Email Address" placeholder="name@example.com" />
                <x-admin-ui::input name="demo_password" type="password" label="Password" placeholder="Enter password" />
                <x-admin-ui::input name="demo_number" type="number" label="Quantity" placeholder="0" />
                <x-admin-ui::input name="demo_date" type="date" label="Date" />
                <x-admin-ui::input name="demo_search" type="search" label="Search" placeholder="Search here..." />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Input Sizes</h2><p>Small, medium and large controls share the same visual language.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="size_small" label="Small input" size="sm" placeholder="Small input" />
                <x-admin-ui::input name="size_medium" label="Medium input" size="md" placeholder="Default input" />
                <x-admin-ui::input name="size_large" label="Large input" size="lg" placeholder="Large input" />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Input Appearances</h2><p>Choose a field treatment that suits the surrounding interface.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="appearance_outline" label="Outlined" appearance="outline" placeholder="Outlined field" />
                <x-admin-ui::input name="appearance_filled" label="Filled" appearance="filled" placeholder="Filled field" />
                <x-admin-ui::input name="appearance_underline" label="Underline" appearance="underline" placeholder="Underline field" />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Labels & Helper Text</h2><p>Optional guidance and required indicators.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="required_field" label="Company Name" required placeholder="Your company" help="This field is required for your profile." />
                <x-admin-ui::input name="optional_field" label="Website" placeholder="https://example.com" help="Add your public website URL (optional)." />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Validation States</h2><p>Inline error messaging with accessible invalid state.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="invalid_email" type="email" label="Email Address" value="not-an-email" error="Please enter a valid email address." />
                <x-admin-ui::input name="valid_email" type="email" label="Email Address" value="hello@example.com" help="Email address looks good." />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Disabled & Read-only</h2><p>Non-editable field states.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::input name="disabled_field" label="Disabled input" value="Disabled value" disabled />
                <x-admin-ui::input name="readonly_field" label="Read-only input" value="This value cannot be edited" readonly />
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Select Controls</h2><p>Native select elements styled to match the input system.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::select name="country" label="Country">
                    <option value="" selected disabled>Select country</option>
                    <option value="in">India</option><option value="us">United States</option><option value="gb">United Kingdom</option>
                </x-admin-ui::select>
                <x-admin-ui::select name="department" label="Department" appearance="filled">
                    <option value="" selected disabled>Select department</option>
                    <option>Sales</option><option>Support</option><option>Engineering</option>
                </x-admin-ui::select>
                <x-admin-ui::select name="priority" label="Priority" size="sm">
                    <option>Low</option><option selected>Normal</option><option>High</option>
                </x-admin-ui::select>
                <x-admin-ui::select name="disabled_select" label="Disabled select" disabled>
                    <option selected>Not available</option>
                </x-admin-ui::select>
            </div>
        </section>

        <section class="rai-input-demo-card">
            <header class="rai-input-demo-card__header"><div><h2>Textareas</h2><p>Multi-line text entry for notes, descriptions and longer content.</p></div></header>
            <div class="rai-input-demo-card__body rai-input-demo-grid">
                <x-admin-ui::textarea name="description" label="Description" rows="4" placeholder="Write a short description..." help="Keep it clear and concise." />
                <x-admin-ui::textarea name="notes" label="Internal notes" rows="4" size="sm" appearance="filled" placeholder="Add internal notes..." />
                <x-admin-ui::textarea name="large_notes" label="Detailed message" rows="5" size="lg" placeholder="Type your message..." />
                <x-admin-ui::textarea name="invalid_notes" label="Required notes" rows="4" error="Please provide a few more details." placeholder="Enter details..." />
            </div>
        </section>
    </div>
</x-admin-ui::layout>
