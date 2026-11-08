<x-admin-ui::layout title="Dropdowns">
<div class="rai-pattern-page rai-dropdown-page">
    <header class="rai-pattern-page__header">
        <div><div class="rai-pattern-page__eyebrow">COMPONENTS / OVERLAYS</div><h1 class="rai-pattern-page__title">Dropdowns</h1><p class="rai-pattern-page__description">Compact contextual menus for actions, navigation and account controls.</p></div>
        <span class="rai-pattern-page__version">v0.3.6</span>
    </header>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Basic dropdown</h2><p>Click the trigger to open the menu. Click outside or press Escape to close it.</p></div>
        <div class="rai-pattern-card__body rai-demo-row">
            <x-admin-ui::dropdown>
                <x-slot:trigger><button type="button" class="rai-btn rai-btn--primary rai-btn--solid" aria-haspopup="menu" aria-expanded="false" data-rai-dropdown-toggle>Actions <span class="rai-dropdown-caret" aria-hidden="true"></span></button></x-slot:trigger>
                <x-admin-ui::dropdown-item href="#edit">Edit details</x-admin-ui::dropdown-item>
                <x-admin-ui::dropdown-item href="#duplicate">Duplicate</x-admin-ui::dropdown-item>
                <x-admin-ui::dropdown-item divider />
                <x-admin-ui::dropdown-item href="#archive" danger>Archive record</x-admin-ui::dropdown-item>
            </x-admin-ui::dropdown>
            <x-admin-ui::dropdown placement="bottom-end" width="sm">
                <x-slot:trigger><button type="button" class="rai-btn rai-btn--secondary rai-btn--outline" aria-haspopup="menu" aria-expanded="false" data-rai-dropdown-toggle>More options <span class="rai-dropdown-caret" aria-hidden="true"></span></button></x-slot:trigger>
                <x-admin-ui::dropdown-item href="#view">View profile</x-admin-ui::dropdown-item>
                <x-admin-ui::dropdown-item href="#settings">Settings</x-admin-ui::dropdown-item>
                <x-admin-ui::dropdown-item disabled>Unavailable</x-admin-ui::dropdown-item>
            </x-admin-ui::dropdown>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Placement & widths</h2><p>Choose a placement that fits the trigger and available space.</p></div>
        <div class="rai-pattern-card__body rai-demo-grid">
            @foreach ([['bottom-start','Bottom start'],['bottom-end','Bottom end'],['top-start','Top start'],['top-end','Top end']] as [$placement, $label])
                <div class="rai-demo-field"><span class="rai-demo-label">{{ $label }}</span>
                    <x-admin-ui::dropdown :placement="$placement" width="sm">
                        <x-slot:trigger><button type="button" class="rai-btn rai-btn--light rai-btn--soft" aria-haspopup="menu" aria-expanded="false" data-rai-dropdown-toggle>{{ $label }} <span class="rai-dropdown-caret" aria-hidden="true"></span></button></x-slot:trigger>
                        <x-admin-ui::dropdown-item href="#one">First action</x-admin-ui::dropdown-item>
                        <x-admin-ui::dropdown-item href="#two">Second action</x-admin-ui::dropdown-item>
                    </x-admin-ui::dropdown>
                </div>
            @endforeach
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Usage notes</h2><p>Keep menu actions short and predictable.</p></div>
        <div class="rai-pattern-card__body"><div class="rai-pattern-note"><strong>Host application owns the action.</strong><p>Dropdown items are ordinary links or buttons. Add your route, data attributes or event listeners in the host application. The component only handles opening, closing, focus and keyboard behavior.</p></div></div>
    </section>
</div>
</x-admin-ui::layout>
