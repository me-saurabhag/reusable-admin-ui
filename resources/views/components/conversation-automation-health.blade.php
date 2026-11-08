@props([
    'activeConversations' => 0,
    'unassignedConversations' => 0,
    'automationSuccessPercent' => 0,
    'failedRunsToday' => 0,
    'title' => 'Conversation & Automation Health',
])

@php
    $formatNumber = static fn ($value): string => number_format((float) $value);
    $formatPercent = static fn ($value): string => number_format((float) $value, 1) . '%';
@endphp

<article {{ $attributes->class(['rai-dashboard-card', 'rai-conversation-health']) }}>
    <header class="rai-conversation-health__header">
        <span class="rai-conversation-health__icon" aria-hidden="true">
            <x-admin-ui::icon name="stroke-chat" size="19" />
        </span>
        <h2 class="rai-conversation-health__title">{{ $title }}</h2>
    </header>

    <p class="rai-conversation-health__description">
        You currently have <strong>{{ $formatNumber($activeConversations) }} active conversations</strong>.
        Of these, <strong>{{ $formatNumber($unassignedConversations) }} conversations are unassigned</strong>
        and may need an agent. Your automations completed
        <strong>{{ $formatPercent($automationSuccessPercent) }} of their runs successfully</strong> today.
        Review the summary below to spot areas that may need attention.
    </p>

    <div class="rai-conversation-health__tiles">
        <div class="rai-conversation-health__tile">
            <span class="rai-conversation-health__tile-label">Active Conversations</span>
            <strong class="rai-conversation-health__tile-value">{{ $formatNumber($activeConversations) }}</strong>
        </div>
        <div class="rai-conversation-health__tile">
            <span class="rai-conversation-health__tile-label">Unassigned Conversations</span>
            <strong class="rai-conversation-health__tile-value">{{ $formatNumber($unassignedConversations) }}</strong>
        </div>
        <div class="rai-conversation-health__tile">
            <span class="rai-conversation-health__tile-label">Automation Success</span>
            <strong class="rai-conversation-health__tile-value">{{ $formatPercent($automationSuccessPercent) }}</strong>
        </div>
        <div class="rai-conversation-health__tile">
            <span class="rai-conversation-health__tile-label">Failed Runs Today</span>
            <strong class="rai-conversation-health__tile-value">{{ $formatNumber($failedRunsToday) }}</strong>
        </div>
    </div>
</article>
