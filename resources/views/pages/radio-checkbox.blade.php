<x-admin-ui::layout title="Radio & Checkbox">
    <div class="rai-choice-page">
        <div class="rai-choice-page__header">
            <div>
                <div class="rai-choice-page__eyebrow">UI COMPONENTS / FORMS</div>
                <h1 class="rai-choice-page__title">Radio & Checkbox</h1>
                <p class="rai-choice-page__description">Clear, accessible selection controls for single-choice, multiple-choice and toggle settings.</p>
            </div>
            <span class="rai-choice-page__version">Form controls</span>
        </div>

        <section class="rai-choice-card">
            <header class="rai-choice-card__header"><div><h2>Checkboxes</h2><p>Allow users to select one or more options from a list.</p></div></header>
            <div class="rai-choice-card__body rai-choice-grid">
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Default</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::checkbox name="interests[]" value="updates" label="Product updates" checked />
                        <x-admin-ui::checkbox name="interests[]" value="tips" label="Tips and tutorials" />
                        <x-admin-ui::checkbox name="interests[]" value="offers" label="Offers and announcements" />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Checked & unchecked</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::checkbox name="terms_demo" label="I agree to the terms and conditions" checked />
                        <x-admin-ui::checkbox name="newsletter_demo" label="Subscribe to newsletter" />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Disabled states</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::checkbox name="locked_checked" label="Enabled option (locked)" checked disabled />
                        <x-admin-ui::checkbox name="locked_unchecked" label="Unavailable option" disabled />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Inline layout</span>
                    <div class="rai-choice-inline">
                        <x-admin-ui::checkbox name="channels[]" value="email" label="Email" checked />
                        <x-admin-ui::checkbox name="channels[]" value="sms" label="SMS" />
                        <x-admin-ui::checkbox name="channels[]" value="whatsapp" label="WhatsApp" />
                    </div>
                </div>
            </div>
        </section>

        <section class="rai-choice-card">
            <header class="rai-choice-card__header"><div><h2>Radio Buttons</h2><p>Use radio buttons when only one option can be selected.</p></div></header>
            <div class="rai-choice-card__body rai-choice-grid">
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Vertical group</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::radio name="plan" value="starter" label="Starter plan" checked />
                        <x-admin-ui::radio name="plan" value="professional" label="Professional plan" />
                        <x-admin-ui::radio name="plan" value="business" label="Business plan" />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Horizontal group</span>
                    <div class="rai-choice-inline">
                        <x-admin-ui::radio name="billing_cycle" value="monthly" label="Monthly" checked />
                        <x-admin-ui::radio name="billing_cycle" value="yearly" label="Yearly" />
                        <x-admin-ui::radio name="billing_cycle" value="lifetime" label="Lifetime" />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Disabled states</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::radio name="delivery_demo" value="standard" label="Standard delivery" checked disabled />
                        <x-admin-ui::radio name="delivery_demo" value="express" label="Express delivery unavailable" disabled />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">With helper text</span>
                    <div class="rai-choice-option-list">
                        <div class="rai-choice-option">
                            <x-admin-ui::radio name="visibility" value="public" label="Public" checked />
                            <span class="rai-choice-option__help">Anyone with the link can view this item.</span>
                        </div>
                        <div class="rai-choice-option">
                            <x-admin-ui::radio name="visibility" value="private" label="Private" />
                            <span class="rai-choice-option__help">Only invited people can access this item.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rai-choice-card">
            <header class="rai-choice-card__header"><div><h2>Switches</h2><p>Use switches for settings that take effect immediately when changed.</p></div></header>
            <div class="rai-choice-card__body rai-choice-grid">
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Default switches</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::switch name="notifications_enabled" label="Push notifications" checked />
                        <x-admin-ui::switch name="weekly_report" label="Weekly report" />
                    </div>
                </div>
                <div class="rai-choice-demo">
                    <span class="rai-choice-demo__label">Disabled switches</span>
                    <div class="rai-choice-stack">
                        <x-admin-ui::switch name="mandatory_setting" label="Mandatory setting" checked disabled />
                        <x-admin-ui::switch name="locked_setting" label="Unavailable setting" disabled />
                    </div>
                </div>
            </div>
        </section>

        <section class="rai-choice-note">
            <strong>Usage tip</strong>
            <p>Checkboxes are for independent selections, radio buttons are for choosing exactly one option, and switches are for on/off settings. Always provide a clear label for each control.</p>
        </section>
    </div>
</x-admin-ui::layout>
