<x-admin-ui::layout title="Tags & Pills">
    <div class="rai-tag-page">
        <div class="rai-tag-page__header">
            <div>
                <div class="rai-tag-page__eyebrow">UI COMPONENTS / ELEMENTS</div>
                <h1 class="rai-tag-page__title">Tags &amp; Pills</h1>
                <p class="rai-tag-page__description">Compact labels for categorisation, status, metadata and removable selections.</p>
            </div>
            <span class="rai-tag-page__version">UI elements</span>
        </div>

        <section class="rai-tag-card">
            <header class="rai-tag-card__header"><div><h2>Tags</h2><p>Use tags to label, categorise or display selected values.</p></div></header>
            <div class="rai-tag-card__body rai-tag-demo-grid">
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Semantic colors</span><div class="rai-tag-wrap">
                    <x-admin-ui::tag variant="primary">Primary</x-admin-ui::tag><x-admin-ui::tag variant="success">Success</x-admin-ui::tag><x-admin-ui::tag variant="warning">Warning</x-admin-ui::tag><x-admin-ui::tag variant="danger">Danger</x-admin-ui::tag><x-admin-ui::tag variant="info">Info</x-admin-ui::tag><x-admin-ui::tag>Neutral</x-admin-ui::tag>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Appearances</span><div class="rai-tag-wrap">
                    <x-admin-ui::tag variant="primary">Soft</x-admin-ui::tag><x-admin-ui::tag variant="primary" appearance="solid">Solid</x-admin-ui::tag><x-admin-ui::tag variant="primary" appearance="outline">Outline</x-admin-ui::tag>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Sizes</span><div class="rai-tag-wrap">
                    <x-admin-ui::tag size="sm">Small tag</x-admin-ui::tag><x-admin-ui::tag>Medium tag</x-admin-ui::tag><x-admin-ui::tag size="lg">Large tag</x-admin-ui::tag>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Removable tags</span><div class="rai-tag-wrap" data-rai-tag-list>
                    <x-admin-ui::tag variant="primary" removable>Laravel</x-admin-ui::tag><x-admin-ui::tag variant="success" removable>PHP</x-admin-ui::tag><x-admin-ui::tag variant="info" removable>Bootstrap</x-admin-ui::tag>
                </div><span class="rai-tag-demo__hint">Click × to remove a tag. This is presentation behavior only; the host application handles form state.</span></div>
            </div>
        </section>

        <section class="rai-tag-card">
            <header class="rai-tag-card__header"><div><h2>Pills</h2><p>Rounded status indicators and compact metadata labels.</p></div></header>
            <div class="rai-tag-card__body rai-tag-demo-grid">
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Status pills</span><div class="rai-tag-wrap">
                    <x-admin-ui::pill variant="success" dot>Active</x-admin-ui::pill><x-admin-ui::pill variant="warning" dot>Pending</x-admin-ui::pill><x-admin-ui::pill variant="danger" dot>Blocked</x-admin-ui::pill><x-admin-ui::pill variant="neutral" dot>Inactive</x-admin-ui::pill>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Semantic appearances</span><div class="rai-tag-wrap">
                    <x-admin-ui::pill variant="primary">Soft pill</x-admin-ui::pill><x-admin-ui::pill variant="primary" appearance="solid">Solid pill</x-admin-ui::pill><x-admin-ui::pill variant="primary" appearance="outline">Outline pill</x-admin-ui::pill>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">Sizes</span><div class="rai-tag-wrap">
                    <x-admin-ui::pill size="sm">Small</x-admin-ui::pill><x-admin-ui::pill>Medium</x-admin-ui::pill><x-admin-ui::pill size="lg">Large</x-admin-ui::pill>
                </div></div>
                <div class="rai-tag-demo"><span class="rai-tag-demo__label">CRM examples</span><div class="rai-tag-wrap">
                    <x-admin-ui::pill variant="success" dot>Connected</x-admin-ui::pill><x-admin-ui::pill variant="info">WhatsApp</x-admin-ui::pill><x-admin-ui::pill variant="warning">Follow-up</x-admin-ui::pill><x-admin-ui::pill variant="primary">VIP Lead</x-admin-ui::pill>
                </div></div>
            </div>
        </section>

        <section class="rai-tag-card">
            <header class="rai-tag-card__header"><div><h2>Practical usage</h2><p>Examples of tags and pills in common admin interfaces.</p></div></header>
            <div class="rai-tag-card__body rai-tag-practical">
                <div class="rai-tag-practical__row"><div><strong>Contact categories</strong><span>Tags assigned to a contact</span></div><div class="rai-tag-wrap"><x-admin-ui::tag variant="primary">Customer</x-admin-ui::tag><x-admin-ui::tag variant="info">Website</x-admin-ui::tag><x-admin-ui::tag variant="success">Verified</x-admin-ui::tag></div></div>
                <div class="rai-tag-practical__row"><div><strong>Conversation status</strong><span>Current state of a conversation</span></div><div class="rai-tag-wrap"><x-admin-ui::pill variant="success" dot>Open</x-admin-ui::pill><x-admin-ui::pill variant="warning">Waiting</x-admin-ui::pill></div></div>
                <div class="rai-tag-practical__row"><div><strong>Message channel</strong><span>Source channel metadata</span></div><div class="rai-tag-wrap"><x-admin-ui::pill variant="success">WhatsApp</x-admin-ui::pill></div></div>
            </div>
        </section>
        <section class="rai-tag-note"><strong>Usage guidance</strong><p>Use tags for categories or removable selections. Use pills for short status and metadata indicators. Keep labels concise and do not rely on color alone to communicate meaning.</p></section>
    </div>
</x-admin-ui::layout>
