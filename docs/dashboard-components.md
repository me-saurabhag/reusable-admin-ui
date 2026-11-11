# Dashboard Components

The package includes a small set of reusable dashboard presentation components. They render UI only; data retrieval, authorization, refresh requests, and business rules remain in the host Laravel application.

## Dashboard preview route

The Host Application includes a local preview page at `/admin/demo/dashboard`. It renders the hero section, all eight WhatsApp CRM statistic cards, messaging activity chart, and conversation/automation health component with demonstration values. These values are intentionally static and are only for visual review; replace them with Host Application data when integrating the components into a real dashboard.

## Dashboard hero section

The component name uses the standard spelling `dashboard-hero-section` (not `dahsboard-hero-section`).

```blade
@php
    $heroStats = [
        ['label' => 'Messages Received', 'value' => number_format($summary['incoming_messages']['today'])],
        ['label' => 'Messages Sent', 'value' => number_format($summary['outgoing_messages']['today'])],
        [
            'label' => 'Active Conversations',
            'value' => number_format($summary['conversations']['active']),
            'indicator' => true,
        ],
    ];
@endphp

<x-admin-ui::dashboard-hero-section
    :title="'Welcome back, ' . $customerName"
    subtitle="Here’s how your communication and customer engagement are performing today."
    :refreshed-at="$refreshedAtLabel"
    :date="$todayLabel"
    :stats="$heroStats"
>
    <x-slot:actions>
        <button type="button" class="rai-dashboard-hero__button" id="refresh-dashboard">
            <x-admin-ui::icon name="refresh" size="15" />
            Refresh Data
        </button>
    </x-slot:actions>
</x-admin-ui::dashboard-hero-section>
```

The button is intentionally supplied by the host application. Its click handler and refresh request belong to the host. The package component supplies the dark green gradient, subtle grid/glow decoration, refresh badge, action/date alignment, and responsive statistics layout.

## Messaging activity chart

The activity array uses the following keys:

- `labels`: x-axis labels.
- `incoming`: incoming message counts; one value for each label.
- `outgoing`: outgoing message counts; one value for each label.
- `period_label`: optional period text shown in the card header.
- `incoming_total` and `outgoing_total`: optional totals. If omitted, the component sums the corresponding data arrays.

```blade
<x-admin-ui::messaging-activity-chart :activity="$messagingActivity" />
```

Example payload:

```php
$messagingActivity = [
    'period_label' => 'Last 7 days',
    'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    'incoming' => [120, 180, 150, 240, 210, 280, 310],
    'outgoing' => [90, 130, 110, 190, 170, 220, 250],
    'incoming_total' => 1490,
    'outgoing_total' => 1160,
];
```

The chart is rendered with SVG and server-side Blade data. It does not require Chart.js, npm, or a JavaScript chart library. Its plot and summary footer use component-scoped spacing so the chart remains balanced at different card widths.

## Conversation and automation health

Pass individual presentation values rather than a Host Application-specific dashboard array. The card keeps its icon/title header, explanatory summary, and four compact metric tiles. The metric labels use a consistent line-height and reserved label area so the values align cleanly. The tile layout adapts to the available component width, not just the viewport width:

```blade
<x-admin-ui::conversation-automation-health
    :active-conversations="$summary['conversations']['active']"
    :unassigned-conversations="$summary['conversations']['unassigned']"
    :automation-success-percent="$summary['automation_health']['success_percent']"
    :failed-runs-today="$summary['automation_health']['failed_runs_today']"
/>
```

## Dashboard statistic card

The existing `stat-card` component has an additional `dashboard` variant. Existing variants remain unchanged.

```blade
<x-admin-ui::stat-card
    variant="dashboard"
    title="WhatsApp Accounts"
    :value="number_format($summary['whatsapp_accounts']['total'])"
    icon="stroke-mobile"
    icon-variant="primary"
    :trend="number_format($summary['whatsapp_accounts']['connected']) . ' connected'"
    trend-variant="neutral"
    primary-label="Connected"
    :primary-value="number_format($summary['whatsapp_accounts']['connected']) . ' accounts'"
    secondary-label="Disconnected"
    :secondary-value="number_format($summary['whatsapp_accounts']['disconnected']) . ' accounts'"
/>
```

Supported `trend-variant` values: `success`, `info`, `neutral`, `warning`, and `danger`. Supported `icon-variant` values: `primary`, `info`, `success`, and `warning`.

The `icon` value must be a symbol ID available in the package icon sprite. You can also supply an `icon` slot when custom markup is needed.

## WhatsApp CRM metrics grid

Use the existing `stat-card` component with the additive `dashboard` variant. Each card receives display values from the Host Application; the package does not calculate CRM metrics. A responsive grid wrapper remains page-level markup owned by the Host.

```blade
<div class="row g-3">
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="WhatsApp Accounts"
            :value="number_format($summary['whatsapp_accounts']['total'])" icon="stroke-mobile"
            trend-variant="neutral" :trend="number_format($summary['whatsapp_accounts']['connected']) . ' connected'"
            primary-label="Connected" :primary-value="number_format($summary['whatsapp_accounts']['connected']) . ' accounts'"
            secondary-label="Disconnected" :secondary-value="number_format($summary['whatsapp_accounts']['disconnected']) . ' accounts'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Total Contacts"
            :value="number_format($summary['contacts']['total'])" icon="stroke-add-user" icon-variant="info"
            :trend="'+' . number_format($summary['contacts']['new_this_month']) . ' this month'"
            primary-label="New today" :primary-value="number_format($summary['contacts']['new_today']) . ' contacts'"
            secondary-label="This month" :secondary-value="number_format($summary['contacts']['new_this_month']) . ' contacts'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Incoming Messages"
            :value="number_format($summary['incoming_messages']['today'])" icon="stroke-chat" icon-variant="info"
            trend="Today" trend-variant="info" primary-label="Yesterday"
            :primary-value="number_format($summary['incoming_messages']['yesterday']) . ' messages'"
            secondary-label="Change" :secondary-value="number_format($summary['incoming_messages']['change_percent'], 1) . '%'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Outgoing Messages"
            :value="number_format($summary['outgoing_messages']['today'])" icon="send" icon-variant="success"
            trend="Today" trend-variant="info" primary-label="Yesterday"
            :primary-value="number_format($summary['outgoing_messages']['yesterday']) . ' messages'"
            secondary-label="Change" :secondary-value="number_format($summary['outgoing_messages']['change_percent'], 1) . '%'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Automations"
            :value="number_format($summary['automations']['total'])" icon="automation"
            trend-variant="neutral" :trend="number_format($summary['automations']['active']) . ' active'"
            primary-label="Active" :primary-value="number_format($summary['automations']['active']) . ' automations'"
            secondary-label="Paused" :secondary-value="number_format($summary['automations']['paused']) . ' automations'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Automated Replies"
            :value="number_format($summary['automated_replies']['today'])" icon="stroke-sms" icon-variant="success"
            trend="Today" trend-variant="info" primary-label="All outgoing"
            :primary-value="number_format($summary['automated_replies']['outgoing_today']) . ' messages'"
            secondary-label="Share" :secondary-value="number_format($summary['automated_replies']['share_percent'], 1) . '%'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Leads"
            :value="number_format($summary['leads']['total'])" icon="profile-check" icon-variant="warning"
            :trend="'+' . number_format($summary['leads']['new_this_month']) . ' this month'"
            primary-label="New today" :primary-value="number_format($summary['leads']['new_today']) . ' leads'"
            secondary-label="This month" :secondary-value="number_format($summary['leads']['new_this_month']) . ' leads'" />
    </div>
    <div class="col-12 col-md-6 col-xl-3">
        <x-admin-ui::stat-card variant="dashboard" title="Open Support Tickets"
            :value="number_format($summary['support_tickets']['open'])" icon="stroke-customer-care" icon-variant="warning"
            trend="Needs attention" trend-variant="warning" primary-label="Awaiting response"
            :primary-value="number_format($summary['support_tickets']['awaiting_response']) . ' tickets'"
            secondary-label="Resolved today" :secondary-value="number_format($summary['support_tickets']['resolved_today']) . ' tickets'" />
    </div>
</div>
```

## Icon sprite

Use the icon component by name:

```blade
<x-admin-ui::icon name="stroke-chat" size="20" />
```

Configuration values that represent icons should contain the sprite symbol name, not raw SVG markup. The package's layout includes the sprite automatically. If you use the icon component in a custom layout, include the sprite once:

```blade
@include('admin-ui::components.icon-sprite')
```

## Dashboard overview layout

The Host Application owns the row that places the Messaging Activity chart beside the Conversation & Automation Health card. Choose the column ratio at page level based on the available content width. For a layout close to the design reference, use approximately 56% for the chart and 44% for the health card on wide screens, then stack the cards on smaller screens. Do not rely on component CSS to override the Host Application grid.

## Responsibility boundary

- Host Application: queries, data preparation, number/date localization, authorization, routes, refresh actions, and JavaScript event handlers.
- Package: component markup, presentation styles, icon sprite rendering, and chart drawing from the supplied values.


## Dashboard overview composition

Use the package overview wrapper when placing Messaging Activity beside Conversation & Automation Health. It owns the reference layout ratio, equal card height, spacing, and responsive stacking; the Host Application only supplies the two existing components and their data.

```blade
<x-admin-ui::dashboard-overview>
    <x-slot:activity>
        <x-admin-ui::messaging-activity-chart :activity="$messagingActivity" />
    </x-slot:activity>

    <x-slot:health>
        <x-admin-ui::conversation-automation-health
            :active-conversations="$summary['conversations']['active']"
            :unassigned-conversations="$summary['conversations']['unassigned']"
            :automation-success-percent="$summary['automation_health']['success_percent']"
            :failed-runs-today="$summary['automation_health']['failed_runs_today']"
        />
    </x-slot:health>
</x-admin-ui::dashboard-overview>
```

The wrapper uses a 4:3 desktop column ratio (approximately 57% chart / 43% health), matching the supplied reference, and equal 356px card heights. Below 992px it stacks the cards and lets their heights follow their content. No page-specific CSS is required in the Host Application.
