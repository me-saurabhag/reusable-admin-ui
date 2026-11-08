<x-admin-ui::layout title="Input Groups">
    <div class="rai-input-groups-page">
        <div class="rai-input-groups-page__header">
            <div>
                <div class="rai-input-groups-page__eyebrow">UI COMPONENTS / FORMS</div>
                <h1 class="rai-input-groups-page__title">Input Groups</h1>
                <p class="rai-input-groups-page__description">Combine form controls with text, icons and actions to create useful, connected input patterns.</p>
            </div>
            <span class="rai-input-groups-page__version">Form controls</span>
        </div>

        <section class="rai-input-group-demo-card">
            <header class="rai-input-group-demo-card__header"><div><h2>Basic Addons</h2><p>Place a contextual prefix or suffix alongside a field.</p></div></header>
            <div class="rai-input-group-demo-card__body rai-input-group-demo-grid">
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-username">Username</label>
                    <x-admin-ui::input-group>
                        <x-slot:prepend>@</x-slot:prepend>
                        <input id="group-username" class="rai-control rai-control--outline" type="text" placeholder="username" aria-label="Username" />
                    </x-admin-ui::input-group>
                    <span class="rai-field__help">Your public account handle.</span>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-email">Email address</label>
                    <x-admin-ui::input-group>
                        <input id="group-email" class="rai-control rai-control--outline" type="text" placeholder="recipient" aria-label="Email recipient" />
                        <x-slot:append>@example.com</x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-price">Price</label>
                    <x-admin-ui::input-group>
                        <x-slot:prepend>$</x-slot:prepend>
                        <input id="group-price" class="rai-control rai-control--outline" type="number" placeholder="0.00" aria-label="Price" />
                        <x-slot:append>.00</x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-url">Website URL</label>
                    <x-admin-ui::input-group>
                        <x-slot:prepend>https://</x-slot:prepend>
                        <input id="group-url" class="rai-control rai-control--outline" type="text" placeholder="yourdomain.com" aria-label="Website domain" />
                    </x-admin-ui::input-group>
                </div>
            </div>
        </section>

        <section class="rai-input-group-demo-card">
            <header class="rai-input-group-demo-card__header"><div><h2>Button Addons</h2><p>Attach an action to the beginning or end of an input.</p></div></header>
            <div class="rai-input-group-demo-card__body rai-input-group-demo-grid">
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-search">Search records</label>
                    <x-admin-ui::input-group>
                        <input id="group-search" class="rai-control rai-control--outline" type="search" placeholder="Search anything..." aria-label="Search records" />
                        <x-slot:append><button type="button" class="rai-input-group__action">Search</button></x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-copy">Share link</label>
                    <x-admin-ui::input-group>
                        <input id="group-copy" class="rai-control rai-control--outline" type="text" value="https://example.com/share/abc" readonly aria-label="Share link" />
                        <x-slot:append><button type="button" class="rai-input-group__action rai-input-group__action--primary">Copy link</button></x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-coupon">Apply coupon</label>
                    <x-admin-ui::input-group>
                        <input id="group-coupon" class="rai-control rai-control--outline" type="text" placeholder="Enter coupon code" aria-label="Coupon code" />
                        <x-slot:append><button type="button" class="rai-input-group__action rai-input-group__action--primary">Apply</button></x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-amount">Transfer amount</label>
                    <x-admin-ui::input-group>
                        <x-slot:prepend>₹</x-slot:prepend>
                        <input id="group-amount" class="rai-control rai-control--outline" type="number" placeholder="Enter amount" aria-label="Transfer amount" />
                        <x-slot:append><button type="button" class="rai-input-group__action">INR</button></x-slot:append>
                    </x-admin-ui::input-group>
                </div>
            </div>
        </section>

        <section class="rai-input-group-demo-card">
            <header class="rai-input-group-demo-card__header"><div><h2>Input Sizes</h2><p>All elements in a group follow the selected size.</p></div></header>
            <div class="rai-input-group-demo-card__body rai-input-group-demo-size-list">
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-size-sm">Small</label>
                    <x-admin-ui::input-group size="sm">
                        <x-slot:prepend>https://</x-slot:prepend>
                        <input id="group-size-sm" class="rai-control rai-control--outline" placeholder="small.example.com" aria-label="Small website" />
                        <x-slot:append>.com</x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-size-md">Default</label>
                    <x-admin-ui::input-group size="md">
                        <x-slot:prepend>https://</x-slot:prepend>
                        <input id="group-size-md" class="rai-control rai-control--outline" placeholder="example.com" aria-label="Website" />
                        <x-slot:append>.com</x-slot:append>
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-size-lg">Large</label>
                    <x-admin-ui::input-group size="lg">
                        <x-slot:prepend>https://</x-slot:prepend>
                        <input id="group-size-lg" class="rai-control rai-control--outline" placeholder="large.example.com" aria-label="Large website" />
                        <x-slot:append>.com</x-slot:append>
                    </x-admin-ui::input-group>
                </div>
            </div>
        </section>

        <section class="rai-input-group-demo-card">
            <header class="rai-input-group-demo-card__header"><div><h2>Multiple Controls</h2><p>Connect related fields while keeping each control independently accessible.</p></div></header>
            <div class="rai-input-group-demo-card__body rai-input-group-demo-grid">
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-name-first">Full name</label>
                    <x-admin-ui::input-group>
                        <input id="group-name-first" class="rai-control rai-control--outline" placeholder="First name" aria-label="First name" />
                        <input class="rai-control rai-control--outline" placeholder="Last name" aria-label="Last name" />
                    </x-admin-ui::input-group>
                </div>
                <div class="rai-input-group-demo-field">
                    <label class="rai-field__label" for="group-message">Message</label>
                    <x-admin-ui::input-group>
                        <textarea id="group-message" class="rai-control rai-control--outline" rows="2" placeholder="Write a short message..." aria-label="Message"></textarea>
                        <x-slot:append><span class="rai-input-group__addon-note">Optional</span></x-slot:append>
                    </x-admin-ui::input-group>
                </div>
            </div>
        </section>
    </div>
</x-admin-ui::layout>
