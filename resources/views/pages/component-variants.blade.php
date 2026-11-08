<x-admin-ui::layout title="Component Showcase">
    <div class="rai-showcase">
        <div class="rai-showcase__intro">
            <div>
                <span class="rai-showcase__eyebrow">DESIGN SYSTEM / COMPONENTS</span>
                <h1 class="rai-showcase__title">Component Showcase</h1>
                <p class="rai-showcase__lead">A visual catalogue of the reusable Admin UI components, appearances, sizes and states.</p>
            </div>
            <span class="rai-showcase__version">v0.3.0</span>
        </div>

        <section class="rai-showcase__section">
            <div class="rai-showcase__section-head"><div><h2>Buttons</h2><p>Semantic colors with solid, outline, soft, ghost, link and gradient appearances.</p></div></div>
            @foreach (['primary','secondary','success','warning','danger','info','dark','light'] as $variant)
                <div class="rai-showcase__row">
                    <div class="rai-showcase__row-label">{{ ucfirst($variant) }}</div>
                    <div class="rai-showcase__samples">
                        <x-admin-ui::button :variant="$variant">Solid</x-admin-ui::button>
                        <x-admin-ui::button :variant="$variant" appearance="outline">Outline</x-admin-ui::button>
                        <x-admin-ui::button :variant="$variant" appearance="soft">Soft</x-admin-ui::button>
                        <x-admin-ui::button :variant="$variant" appearance="ghost">Ghost</x-admin-ui::button>
                        @if (in_array($variant, ['primary','success','danger']))
                            <x-admin-ui::button :variant="$variant" appearance="gradient">Gradient</x-admin-ui::button>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="rai-showcase__row">
                <div class="rai-showcase__row-label">Sizes & states</div>
                <div class="rai-showcase__samples">
                    <x-admin-ui::button size="sm">Small</x-admin-ui::button>
                    <x-admin-ui::button size="md">Medium</x-admin-ui::button>
                    <x-admin-ui::button size="lg">Large</x-admin-ui::button>
                    <x-admin-ui::button loading>Loading</x-admin-ui::button>
                    <x-admin-ui::button disabled>Disabled</x-admin-ui::button>
                    <x-admin-ui::button rounded appearance="soft">Rounded</x-admin-ui::button>
                    <x-admin-ui::button block>Full width</x-admin-ui::button>
                </div>
            </div>
            <div class="rai-showcase__row">
                <div class="rai-showcase__row-label">Button group</div>
                <div class="rai-showcase__samples">
                    <x-admin-ui::button-group>
                        <x-admin-ui::button variant="primary">Day</x-admin-ui::button>
                        <x-admin-ui::button variant="primary" appearance="outline">Week</x-admin-ui::button>
                        <x-admin-ui::button variant="primary" appearance="outline">Month</x-admin-ui::button>
                    </x-admin-ui::button-group>
                </div>
            </div>
        </section>

        <section class="rai-showcase__section">
            <div class="rai-showcase__section-head"><div><h2>Form controls</h2><p>Consistent labels, control heights, focus rings and validation feedback.</p></div></div>
            <div class="rai-showcase__form-grid">
                <x-admin-ui::input name="demo_default" label="Outlined input" placeholder="Enter your name" help="Your name as it appears on your profile." />
                <x-admin-ui::input name="demo_filled" label="Filled input" appearance="filled" placeholder="name@example.com" />
                <x-admin-ui::input name="demo_underline" label="Underline input" appearance="underline" placeholder="Enter a value" />
                <x-admin-ui::input name="demo_error" label="Validation error" error="Please enter a valid email address." value="invalid-email" />
                <x-admin-ui::input name="demo_disabled" label="Disabled input" disabled value="This field is disabled" />
                <x-admin-ui::input name="demo_small" label="Small input" size="sm" placeholder="Small control" />
                <x-admin-ui::input name="demo_large" label="Large input" size="lg" placeholder="Large control" />
                <x-admin-ui::select name="demo_select" label="Select field">
                    <option value="">Choose a status</option><option>Active</option><option>Pending</option><option>Inactive</option>
                </x-admin-ui::select>
                <x-admin-ui::select name="demo_select_filled" label="Filled select" appearance="filled">
                    <option value="">Choose a team</option><option>Support</option><option>Sales</option><option>Operations</option>
                </x-admin-ui::select>
                <x-admin-ui::textarea name="demo_message" label="Textarea" placeholder="Write your message..." help="Keep your message clear and concise." />
                <x-admin-ui::textarea name="demo_textarea_error" label="Textarea error" error="This field is required." rows="3" />
            </div>
            <div class="rai-showcase__controls">
                <div class="rai-showcase__control-group">
                    <h3>Checkboxes</h3>
                    <x-admin-ui::checkbox name="demo_check_a" label="Email notifications" checked />
                    <x-admin-ui::checkbox name="demo_check_b" label="SMS notifications" />
                    <x-admin-ui::checkbox name="demo_check_c" label="Disabled option" disabled />
                </div>
                <div class="rai-showcase__control-group">
                    <h3>Radio buttons</h3>
                    <x-admin-ui::radio name="demo_plan" value="starter" label="Starter plan" checked />
                    <x-admin-ui::radio name="demo_plan" value="pro" label="Professional plan" />
                    <x-admin-ui::radio name="demo_plan" value="enterprise" label="Disabled plan" disabled />
                </div>
                <div class="rai-showcase__control-group">
                    <h3>Switches</h3>
                    <x-admin-ui::switch name="demo_switch_a" label="Enable automation" checked />
                    <x-admin-ui::switch name="demo_switch_b" label="Allow public access" />
                    <x-admin-ui::switch name="demo_switch_c" label="Disabled switch" disabled />
                </div>
            </div>
        </section>

        <section class="rai-showcase__section">
            <div class="rai-showcase__section-head"><div><h2>Badges & status</h2><p>Soft, solid and outline treatments for status and category labels.</p></div></div>
            @foreach (['primary','success','warning','danger','info','neutral'] as $variant)
                <div class="rai-showcase__row">
                    <div class="rai-showcase__row-label">{{ ucfirst($variant) }}</div>
                    <div class="rai-showcase__samples">
                        <x-admin-ui::badge :variant="$variant">Soft</x-admin-ui::badge>
                        <x-admin-ui::badge :variant="$variant" appearance="solid">Solid</x-admin-ui::badge>
                        <x-admin-ui::badge :variant="$variant" appearance="outline">Outline</x-admin-ui::badge>
                        <x-admin-ui::badge :variant="$variant" dot>With dot</x-admin-ui::badge>
                        <x-admin-ui::badge :variant="$variant" pill>Pill</x-admin-ui::badge>
                    </div>
                </div>
            @endforeach
        </section>

        <section class="rai-showcase__section">
            <div class="rai-showcase__section-head"><div><h2>Typography</h2><p>Heading hierarchy and text treatments.</p></div></div>
            <div class="rai-showcase__type-samples">
                @foreach ([1,2,3,4,5,6] as $level)
                    <x-admin-ui::heading :level="$level">Heading level {{ $level }}</x-admin-ui::heading>
                @endforeach
                <x-admin-ui::text>Body text — The quick brown fox jumps over the lazy dog.</x-admin-ui::text>
                <x-admin-ui::text size="small" color="muted">Small muted supporting text.</x-admin-ui::text>
                <x-admin-ui::text size="caption" color="secondary">Caption text for secondary information.</x-admin-ui::text>
            </div>
        </section>

        <section class="rai-showcase__section">
            <div class="rai-showcase__section-head"><div><h2>Layout & spacing</h2><p>Use Stack for consistent vertical rhythm.</p></div></div>
            <x-admin-ui::stack gap="3">
                <div class="rai-showcase__sample-box">Stack item one</div>
                <div class="rai-showcase__sample-box">Stack item two</div>
                <div class="rai-showcase__sample-box">Stack item three</div>
            </x-admin-ui::stack>
        </section>
    </div>
</x-admin-ui::layout>
