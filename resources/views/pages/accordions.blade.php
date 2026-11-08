<x-admin-ui::layout title="Accordion">
<div class="rai-pattern-page rai-accordion-page">
    <header class="rai-pattern-page__header">
        <div><div class="rai-pattern-page__eyebrow">COMPONENTS / CONTENT</div><h1 class="rai-pattern-page__title">Accordion</h1><p class="rai-pattern-page__description">Organize related information into expandable sections without overwhelming the page.</p></div>
        <span class="rai-pattern-page__version">v0.3.6</span>
    </header>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Default accordion</h2><p>Multiple sections can remain open at the same time.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::accordion mode="multiple">
                <x-admin-ui::accordion-item title="What is included in the plan?" open>
                    <p>The plan includes the core workspace, contact management, shared inbox and standard reporting tools.</p>
                </x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Can I add more team members?">
                    <p>Yes. Team members can be invited from the host application's user and team management screens.</p>
                </x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Can I change my subscription?">
                    <p>Subscription changes are handled by your billing workflow. Connect this content to the relevant host application process.</p>
                </x-admin-ui::accordion-item>
            </x-admin-ui::accordion>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Single-open accordion</h2><p>Opening one section automatically closes the previously open section.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::accordion mode="single" appearance="bordered">
                <x-admin-ui::accordion-item title="Account information" open><p>Manage account name, contact details and profile preferences.</p></x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Security settings"><p>Configure password, active sessions and available security options.</p></x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Notification preferences"><p>Choose which product and account notifications should be delivered.</p></x-admin-ui::accordion-item>
            </x-admin-ui::accordion>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Separated & disabled states</h2><p>Alternative visual treatments for settings and help content.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::accordion mode="multiple" appearance="separated">
                <x-admin-ui::accordion-item title="Enabled section" open><p>This section is available and can be expanded or collapsed.</p></x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Unavailable section" disabled><p>This content cannot currently be opened.</p></x-admin-ui::accordion-item>
                <x-admin-ui::accordion-item title="Another section"><p>Additional information can be placed here.</p></x-admin-ui::accordion-item>
            </x-admin-ui::accordion>
        </div>
    </section>
</div>
</x-admin-ui::layout>
