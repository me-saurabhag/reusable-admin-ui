<x-admin-ui::layout title="Statistics Cards">
<div class="rai-pattern-page rai-stat-page">
    <header class="rai-pattern-page__header">
        <div>
            <div class="rai-pattern-page__eyebrow">COMPONENTS / DATA DISPLAY</div>
            <h1 class="rai-pattern-page__title">Statistics Cards</h1>
            <p class="rai-pattern-page__description">Ready-made metric cards for dashboards, reports and business summaries.</p>
        </div>
        <span class="rai-pattern-page__version">v0.3.8</span>
    </header>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>01. Split Statistics</h2><p>Main metric with two supporting values.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="split" title="WhatsApp Accounts" value="0" badge="0 connected" primary-label="Connected" primary-value="0 accounts" secondary-label="Disconnected" secondary-value="0 accounts" icon="▣">
                <x-slot:iconSlot><span aria-hidden="true">▣</span></x-slot:iconSlot>
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>02. Revenue</h2><p>Prominent value, icon and growth comparison.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="revenue" title="Total Revenue" value="$48,290" trend="↑ 12.8%" trend-label="from last month" icon="$">
                <x-slot:iconSlot><span aria-hidden="true">$</span></x-slot:iconSlot>
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>03. Accent Action</h2><p>Left accent strip with a prominent circular action.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="accent-action" title="Collection" value="127730">
                <x-slot:actionIconSlot><span aria-hidden="true">↓</span></x-slot:actionIconSlot>
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>04. Icon Block</h2><p>Large colored icon block beside the metric.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="icon-block" title="TOTAL DEPOSITS" value="7278281" icon="+">
                <x-slot:iconSlot><span aria-hidden="true">＋</span></x-slot:iconSlot>
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>05. Compact</h2><p>Small footprint for secondary dashboard metrics.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="compact" title="Utility Payments" value="₹309" href="#">
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>06. Watermark</h2><p>Decorative background icon with a trend indicator.</p></div>
        <div class="rai-pattern-card__body rai-stat-demo-grid">
            <x-admin-ui::stat-card variant="watermark" title="Total Orders" value="4805" trend="↑ +2.5%" trend-label="from last week" icon="🛒">
                <x-slot:iconSlot><span aria-hidden="true">🛒</span></x-slot:iconSlot>
                <x-slot:watermarkIconSlot><span aria-hidden="true">🛒</span></x-slot:watermarkIconSlot>
            </x-admin-ui::stat-card>
        </div>
    </section>

    <section class="rai-pattern-card">
        <div class="rai-pattern-card__header"><h2>Usage example</h2><p>Choose a variant and provide only the data relevant to that design.</p></div>
        <div class="rai-pattern-card__body">
<pre class="rai-stat-code"><code>&lt;x-admin-ui::stat-card
    variant="revenue"
    title="Total Revenue"
    :value="$dashboard['revenue']"
    :trend="$dashboard['revenue_trend']"
    trend-label="from last month"
&gt;
    &lt;x-slot:iconSlot&gt;
        &lt;img src="/assets/icons/revenue.svg" alt=""&gt;
    &lt;/x-slot:iconSlot&gt;
&lt;/x-admin-ui::stat-card&gt;</code></pre>
        </div>
    </section>
</div>
</x-admin-ui::layout>
