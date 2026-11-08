@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    // Demonstration-only values. Replace these with dashboard data from the Host Application.
    $heroStats = [
        ['label' => 'Messages Received', 'value' => '2,846'],
        ['label' => 'Messages Sent', 'value' => '1,932'],
        ['label' => 'Active Conversations', 'value' => '128', 'indicator' => true],
    ];

    $messagingActivity = [
        'period_label' => 'Last 7 days',
        'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        'incoming' => [320, 410, 365, 520, 470, 610, 560],
        'outgoing' => [250, 330, 290, 420, 390, 480, 445],
        'incoming_total' => 3255,
        'outgoing_total' => 2605,
    ];
@endphp

<div class="rai-dashboard-preview">
    <x-admin-ui::dashboard-hero-section
        title="Welcome back, Alex!"
        subtitle="Here’s what’s happening with your WhatsApp CRM today."
        refreshed-at="Updated just now"
        :date="now()->format('l, F j, Y')"
        :stats="$heroStats"
    >
        <x-slot:actions>
            <button type="button" class="rai-dashboard-hero__button" onclick="window.location.reload()">
                <x-admin-ui::icon name="refresh" size="15" />
                Refresh Dashboard
            </button>
        </x-slot:actions>
    </x-admin-ui::dashboard-hero-section>

    <div class="row g-3 mt-1">
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="WhatsApp Accounts" value="12" icon="stroke-mobile"
                trend="8 connected" trend-variant="success" primary-label="Connected" primary-value="8 accounts"
                secondary-label="Disconnected" secondary-value="4 accounts" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Total Contacts" value="8,420" icon="stroke-add-user" icon-variant="info"
                trend="+124 this month" trend-variant="success" primary-label="New today" primary-value="18 contacts"
                secondary-label="This month" secondary-value="124 contacts" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Incoming Messages" value="2,846" icon="stroke-chat" icon-variant="info"
                trend="Today" trend-variant="info" primary-label="Yesterday" primary-value="2,410 messages"
                secondary-label="Change" secondary-value="+18.1%" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Outgoing Messages" value="1,932" icon="send" icon-variant="success"
                trend="Today" trend-variant="info" primary-label="Yesterday" primary-value="1,705 messages"
                secondary-label="Change" secondary-value="+13.3%" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Automations" value="24" icon="automation"
                trend="19 active" trend-variant="success" primary-label="Active" primary-value="19 automations"
                secondary-label="Paused" secondary-value="5 automations" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Automated Replies" value="684" icon="stroke-sms" icon-variant="success"
                trend="Today" trend-variant="info" primary-label="All outgoing" primary-value="1,932 messages"
                secondary-label="Share" secondary-value="35.4%" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Leads" value="356" icon="profile-check" icon-variant="warning"
                trend="+32 this month" trend-variant="success" primary-label="New today" primary-value="7 leads"
                secondary-label="This month" secondary-value="32 leads" />
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <x-admin-ui::stat-card variant="dashboard" title="Open Support Tickets" value="18" icon="stroke-customer-care" icon-variant="warning"
                trend="Needs attention" trend-variant="warning" primary-label="Awaiting response" primary-value="6 tickets"
                secondary-label="Resolved today" secondary-value="14 tickets" />
        </div>
    </div>

    <div class="row g-3 mt-1 align-items-stretch">
        <div class="col-12 col-xl-8">
            <x-admin-ui::messaging-activity-chart :activity="$messagingActivity" />
        </div>
        <div class="col-12 col-xl-4">
            <x-admin-ui::conversation-automation-health
                :active-conversations="128"
                :unassigned-conversations="17"
                :automation-success-percent="96.8"
                :failed-runs-today="5"
            />
        </div>
    </div>
</div>
@endsection
