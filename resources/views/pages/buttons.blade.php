<x-admin-ui::layout title="Buttons">
    <div class="rai-buttons-page">
        <div class="rai-buttons-page__header">
            <div>
                <div class="rai-buttons-page__eyebrow">UI COMPONENTS / BUTTONS</div>
                <h1 class="rai-buttons-page__title">Buttons</h1>
                <p class="rai-buttons-page__description">Button styles, appearances, sizes, shapes, icon placements and interaction states.</p>
            </div>
            <span class="rai-buttons-page__version">Button library</span>
        </div>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Flat Buttons</h2><p>Square-corner buttons for compact, high-density interfaces.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark','light'] as $variant)
                    <x-admin-ui::button :variant="$variant" square>{{ ucfirst($variant) }}</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Default Buttons</h2><p>Standard solid buttons in semantic color variants.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark','light'] as $variant)
                    <x-admin-ui::button :variant="$variant">{{ ucfirst($variant) }} Button</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Light Buttons</h2><p>Soft tinted backgrounds for secondary actions and less prominent controls.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark','light'] as $variant)
                    <x-admin-ui::button :variant="$variant" appearance="soft">{{ ucfirst($variant) }} Button</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Button Sizes</h2><p>Extra small, small, default and large button dimensions.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex rai-button-demo-card__body--align-center">
                <x-admin-ui::button size="lg">Large button</x-admin-ui::button>
                <x-admin-ui::button size="md">Default button</x-admin-ui::button>
                <x-admin-ui::button size="sm">Small button</x-admin-ui::button>
                <x-admin-ui::button size="xs">Extra small</x-admin-ui::button>
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Outline Buttons</h2><p>Transparent backgrounds with semantic border and text colors.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark','light'] as $variant)
                    <x-admin-ui::button :variant="$variant" appearance="outline">{{ ucfirst($variant) }}</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Bold Border Outline</h2><p>Stronger outline emphasis for actions that need more visual weight.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger'] as $variant)
                    <x-admin-ui::button :variant="$variant" appearance="outline" outline-width="bold">{{ ucfirst($variant) }}</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Rounded Buttons</h2><p>Pill-shaped soft and solid button styles.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark'] as $variant)
                    <x-admin-ui::button :variant="$variant" appearance="soft" pill>{{ ucfirst($variant) }}</x-admin-ui::button>
                @endforeach
                @foreach (['primary','success','danger'] as $variant)
                    <x-admin-ui::button :variant="$variant" pill>{{ ucfirst($variant) }} solid</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Rounded Outline Buttons</h2><p>Pill shape combined with outline appearance.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                @foreach (['primary','secondary','success','info','warning','danger','dark'] as $variant)
                    <x-admin-ui::button :variant="$variant" appearance="outline" pill>{{ ucfirst($variant) }}</x-admin-ui::button>
                @endforeach
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Icon Buttons & Icon with Text</h2><p>Use the leading and trailing slots to supply your own icon markup or icon component.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                <x-admin-ui::button variant="primary" square aria-label="Add item"><x-slot:leading>＋</x-slot:leading></x-admin-ui::button>
                <x-admin-ui::button variant="success" square aria-label="Confirm"><x-slot:leading>✓</x-slot:leading></x-admin-ui::button>
                <x-admin-ui::button variant="danger" appearance="outline" square aria-label="Delete"><x-slot:leading>×</x-slot:leading></x-admin-ui::button>
                <x-admin-ui::button variant="primary"><x-slot:leading>＋</x-slot:leading>Add New</x-admin-ui::button>
                <x-admin-ui::button variant="success">Continue<x-slot:trailing>→</x-slot:trailing></x-admin-ui::button>
                <x-admin-ui::button variant="secondary" appearance="soft"><x-slot:leading>⚙</x-slot:leading>Settings</x-admin-ui::button>
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Disabled Buttons</h2><p>Disabled solid, pill, outline and soft states.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                <x-admin-ui::button disabled>Disabled</x-admin-ui::button>
                <x-admin-ui::button variant="warning" pill disabled>Disabled pill</x-admin-ui::button>
                <x-admin-ui::button variant="primary" appearance="outline" disabled>Disabled outline</x-admin-ui::button>
                <x-admin-ui::button variant="success" appearance="soft" disabled>Disabled soft</x-admin-ui::button>
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Loading Buttons</h2><p>Loading state disables the button to prevent repeated submission.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                <x-admin-ui::button loading>Processing</x-admin-ui::button>
                <x-admin-ui::button variant="success" appearance="outline" loading>Saving</x-admin-ui::button>
                <x-admin-ui::button variant="primary" size="sm" loading>Loading</x-admin-ui::button>
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Button Groups</h2><p>Attached controls and spaced button groups.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--flex">
                <x-admin-ui::button-group>
                    <x-admin-ui::button variant="primary">Left</x-admin-ui::button>
                    <x-admin-ui::button variant="primary" appearance="outline">Middle</x-admin-ui::button>
                    <x-admin-ui::button variant="primary" appearance="outline">Right</x-admin-ui::button>
                </x-admin-ui::button-group>
                <x-admin-ui::button-group attached>
                    <x-admin-ui::button variant="secondary">Day</x-admin-ui::button>
                    <x-admin-ui::button variant="secondary">Week</x-admin-ui::button>
                    <x-admin-ui::button variant="secondary">Month</x-admin-ui::button>
                </x-admin-ui::button-group>
            </div>
        </section>

        <section class="rai-button-demo-card">
            <header class="rai-button-demo-card__header">
                <div><h2>Full Width Buttons</h2><p>Buttons that occupy the available container width.</p></div>
            </header>
            <div class="rai-button-demo-card__body rai-button-demo-card__body--stack">
                <x-admin-ui::button block variant="primary">Primary Full Width</x-admin-ui::button>
                <x-admin-ui::button block variant="success" appearance="outline">Outline Full Width</x-admin-ui::button>
            </div>
        </section>
    </div>
</x-admin-ui::layout>
