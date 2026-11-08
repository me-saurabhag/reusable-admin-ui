<x-admin-ui::layout title="Lists">
<div class="rai-pattern-page rai-list-page">
    <header class="rai-pattern-page__header">
        <div><div class="rai-pattern-page__eyebrow">COMPONENTS / CONTENT</div><h1 class="rai-pattern-page__title">Lists</h1><p class="rai-pattern-page__description">Flexible list patterns for settings, activity, contacts and actionable records.</p></div>
        <span class="rai-pattern-page__version">v0.3.7</span>
    </header>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Basic lists</h2><p>Simple, ordered and unordered content lists.</p></div>
        <div class="rai-pattern-card__body rai-list-showcase-grid">
            <div><h3 class="rai-list-demo-label">Unordered</h3>
                <x-admin-ui::list marker="bullet" gap="sm">
                    <x-admin-ui::list-item>Manage contacts and conversations</x-admin-ui::list-item>
                    <x-admin-ui::list-item>Configure team permissions</x-admin-ui::list-item>
                    <x-admin-ui::list-item>Review messaging reports</x-admin-ui::list-item>
                </x-admin-ui::list>
            </div>
            <div><h3 class="rai-list-demo-label">Ordered</h3>
                <x-admin-ui::list type="ordered" marker="number" gap="sm">
                    <x-admin-ui::list-item>Create your workspace</x-admin-ui::list-item>
                    <x-admin-ui::list-item>Connect a messaging channel</x-admin-ui::list-item>
                    <x-admin-ui::list-item>Invite your team</x-admin-ui::list-item>
                </x-admin-ui::list>
            </div>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Bordered & divided lists</h2><p>Useful for grouped settings and compact data rows.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::list appearance="bordered" gap="none">
                <x-admin-ui::list-item title="General settings" description="Workspace name, language and regional preferences" meta="Updated"/>
                <x-admin-ui::list-item title="Team management" description="Manage members, roles and access permissions" meta="12 users"/>
                <x-admin-ui::list-item title="Notifications" description="Configure email and in-app notifications" meta="Enabled"/>
            </x-admin-ui::list>
            <div class="rai-list-demo-spacer"></div>
            <x-admin-ui::list appearance="divided" gap="none">
                <x-admin-ui::list-item title="Incoming messages" description="Messages received across connected channels" meta="1,284"/>
                <x-admin-ui::list-item title="Outgoing messages" description="Messages sent by your team and automations" meta="946"/>
                <x-admin-ui::list-item title="Automated replies" description="Replies handled by configured workflows" meta="328"/>
            </x-admin-ui::list>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Icon & action lists</h2><p>Leading visual indicators and trailing actions through slots.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::list appearance="divided" gap="none">
                <x-admin-ui::list-item title="WhatsApp channel" description="Connected and ready to receive messages" meta="Connected">
                    <x-slot:leading><span class="rai-list-icon rai-list-icon--success">✓</span></x-slot:leading>
                    <x-slot:trailing><span class="rai-list-action">Manage</span></x-slot:trailing>
                </x-admin-ui::list-item>
                <x-admin-ui::list-item title="Email notifications" description="Daily account and activity summaries" meta="Enabled">
                    <x-slot:leading><span class="rai-list-icon rai-list-icon--info">✉</span></x-slot:leading>
                    <x-slot:trailing><span class="rai-list-action">Configure</span></x-slot:trailing>
                </x-admin-ui::list-item>
                <x-admin-ui::list-item title="Billing profile" description="Payment method needs your attention" meta="Action needed">
                    <x-slot:leading><span class="rai-list-icon rai-list-icon--warning">!</span></x-slot:leading>
                    <x-slot:trailing><span class="rai-list-action">Review</span></x-slot:trailing>
                </x-admin-ui::list-item>
            </x-admin-ui::list>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Activity list</h2><p>Recent events with avatar markers and timestamps.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::list appearance="divided" gap="none">
                <x-admin-ui::list-item title="New contact added" description="Aarav Sharma was added to the customer database." meta="5 min ago"><x-slot:leading><span class="rai-list-avatar">AS</span></x-slot:leading></x-admin-ui::list-item>
                <x-admin-ui::list-item title="Message delivered" description="Your campaign message was successfully delivered." meta="18 min ago"><x-slot:leading><span class="rai-list-avatar rai-list-avatar--blue">✓</span></x-slot:leading></x-admin-ui::list-item>
                <x-admin-ui::list-item title="Automation updated" description="Welcome sequence was modified by Priya." meta="1 hour ago"><x-slot:leading><span class="rai-list-avatar rai-list-avatar--purple">PA</span></x-slot:leading></x-admin-ui::list-item>
            </x-admin-ui::list>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Contact list</h2><p>Compact contact rows with avatar, status and action.</p></div>
        <div class="rai-pattern-card__body">
            <x-admin-ui::list appearance="bordered" size="sm" gap="none">
                <x-admin-ui::list-item title="Ananya Verma" description="+91 98765 43210" meta="Active"><x-slot:leading><span class="rai-list-avatar">AV</span></x-slot:leading><x-slot:trailing><span class="rai-list-action">View</span></x-slot:trailing></x-admin-ui::list-item>
                <x-admin-ui::list-item title="Rahul Mehta" description="+91 91234 56780" meta="New"><x-slot:leading><span class="rai-list-avatar rai-list-avatar--blue">RM</span></x-slot:leading><x-slot:trailing><span class="rai-list-action">View</span></x-slot:trailing></x-admin-ui::list-item>
            </x-admin-ui::list>
        </div>
    </section>
</div>
</x-admin-ui::layout>
