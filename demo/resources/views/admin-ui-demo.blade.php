@extends('layouts.admin')

@section('title', 'Admin UI · Phase 1')
@section('page-title', 'Dashboard')

{{-- Marker used by the root-page JavaScript live-card demo. --}}
@section('content')

    <div id="header-live-demo" hidden></div>
<div class="rai-page-heading" id="overview">
        <div>
            <h2 class="rai-page-heading__title">Overview</h2>
            <p class="rai-page-heading__description">A representative UI-only integration demo. All figures below are illustrative.</p>
        </div>
        <x-admin-ui::button-primary type="button">＋ Create report</x-admin-ui::button-primary>
    </div>

    <x-admin-ui::row class="mb-4">
        <x-admin-ui::column span="12" sm="6" lg="3"><x-admin-ui::stat-card label="Total Revenue" value="$48,290" note="↑ 12.8% from last month" icon="$" /></x-admin-ui::column>
        <x-admin-ui::column span="12" sm="6" lg="3"><x-admin-ui::stat-card label="Total Customers" value="2,840" note="↑ 8.2% from last month" icon="♙" /></x-admin-ui::column>
        <x-admin-ui::column span="12" sm="6" lg="3"><x-admin-ui::stat-card label="Orders" value="1,426" note="↓ 2.4% from last month" icon="▤" /></x-admin-ui::column>
        <x-admin-ui::column span="12" sm="6" lg="3"><x-admin-ui::stat-card label="Conversion Rate" value="4.82%" note="↑ 1.1% from last month" icon="↗" /></x-admin-ui::column>
    </x-admin-ui::row>

    <x-admin-ui::row class="mb-4">
        <x-admin-ui::column span="12" lg="8">
            <x-admin-ui::card title="Revenue overview" description="Illustrative monthly performance">
                <x-slot:actions><div class="rai-chart__legend"><span class="rai-chart__legend-dot"></span> Revenue</div></x-slot:actions>
                <div class="rai-chart">
                    <svg class="rai-chart__plot" viewBox="0 0 680 245" role="img" aria-label="Illustrative revenue line chart, trending upward from January through December">
                        <defs>
                            <linearGradient id="rai-chart-fill" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#07913B" stop-opacity=".18"/>
                                <stop offset="100%" stop-color="#07913B" stop-opacity="0"/>
                            </linearGradient>
                        </defs>
                        <line class="rai-chart__grid" x1="42" y1="28" x2="660" y2="28"/>
                        <line class="rai-chart__grid" x1="42" y1="76" x2="660" y2="76"/>
                        <line class="rai-chart__grid" x1="42" y1="124" x2="660" y2="124"/>
                        <line class="rai-chart__grid" x1="42" y1="172" x2="660" y2="172"/>
                        <line class="rai-chart__grid" x1="42" y1="210" x2="660" y2="210"/>
                        <text class="rai-chart__axis" x="4" y="32">$50k</text><text class="rai-chart__axis" x="4" y="80">$40k</text><text class="rai-chart__axis" x="4" y="128">$30k</text><text class="rai-chart__axis" x="4" y="176">$20k</text><text class="rai-chart__axis" x="4" y="214">$10k</text>
                        <path class="rai-chart__area" d="M48 178 L103 157 L158 166 L213 126 L268 139 L323 104 L378 116 L433 82 L488 91 L543 59 L598 68 L650 35 L650 210 L48 210 Z"/>
                        <path class="rai-chart__line" d="M48 178 L103 157 L158 166 L213 126 L268 139 L323 104 L378 116 L433 82 L488 91 L543 59 L598 68 L650 35"/>
                        <circle class="rai-chart__point" cx="48" cy="178" r="4"/><circle class="rai-chart__point" cx="158" cy="166" r="4"/><circle class="rai-chart__point" cx="268" cy="139" r="4"/><circle class="rai-chart__point" cx="378" cy="116" r="4"/><circle class="rai-chart__point" cx="488" cy="91" r="4"/><circle class="rai-chart__point" cx="598" cy="68" r="4"/><circle class="rai-chart__point" cx="650" cy="35" r="4"/>
                        <text class="rai-chart__axis" x="44" y="235">Jan</text><text class="rai-chart__axis" x="98" y="235">Feb</text><text class="rai-chart__axis" x="153" y="235">Mar</text><text class="rai-chart__axis" x="208" y="235">Apr</text><text class="rai-chart__axis" x="263" y="235">May</text><text class="rai-chart__axis" x="318" y="235">Jun</text><text class="rai-chart__axis" x="373" y="235">Jul</text><text class="rai-chart__axis" x="428" y="235">Aug</text><text class="rai-chart__axis" x="483" y="235">Sep</text><text class="rai-chart__axis" x="538" y="235">Oct</text><text class="rai-chart__axis" x="593" y="235">Nov</text><text class="rai-chart__axis" x="642" y="235">Dec</text>
                    </svg>
                </div>
            </x-admin-ui::card>
        </x-admin-ui::column>
        <x-admin-ui::column span="12" lg="4">
            <x-admin-ui::card title="Order status" description="Sample UI states only.">
                <div class="rai-status-list">
                    <div class="rai-status-item">
                        <div class="rai-status-item__top"><span class="rai-status-item__label">Completed</span><span class="rai-status-item__value">68%</span></div>
                        <div class="rai-progress" role="progressbar" aria-label="Completed orders" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"><div class="rai-progress__bar" style="width:68%"></div></div>
                    </div>
                    <div class="rai-status-item">
                        <div class="rai-status-item__top"><span class="rai-status-item__label">Processing</span><span class="rai-status-item__value">22%</span></div>
                        <div class="rai-progress" role="progressbar" aria-label="Processing orders" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"><div class="rai-progress__bar rai-progress__bar--warning" style="width:22%"></div></div>
                    </div>
                    <div class="rai-status-item">
                        <div class="rai-status-item__top"><span class="rai-status-item__label">Cancelled</span><span class="rai-status-item__value">10%</span></div>
                        <div class="rai-progress" role="progressbar" aria-label="Cancelled orders" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><div class="rai-progress__bar rai-progress__bar--danger" style="width:10%"></div></div>
                    </div>
                </div>
            </x-admin-ui::card>
        </x-admin-ui::column>
    </x-admin-ui::row>

    <x-admin-ui::card title="Recent activity" description="Example rows to demonstrate table styling.">
        <x-slot:actions><x-admin-ui::button-outline size="sm" type="button">View all</x-admin-ui::button-outline></x-slot:actions>
        <div class="rai-table-wrap"><table class="table rai-table"><thead><tr><th scope="col">Customer</th><th scope="col">Reference</th><th scope="col">Date</th><th scope="col">Status</th><th scope="col">Amount</th></tr></thead><tbody>
            <tr><td><strong>Olivia Martin</strong><div class="small text-secondary">olivia@example.com</div></td><td>#ORD-1048</td><td>22 Oct 2026</td><td><x-admin-ui::badge-success>Completed</x-admin-ui::badge-success></td><td>$248.00</td></tr>
            <tr><td><strong>Jackson Lee</strong><div class="small text-secondary">jackson@example.com</div></td><td>#ORD-1047</td><td>21 Oct 2026</td><td><x-admin-ui::badge-warning>Processing</x-admin-ui::badge-warning></td><td>$124.50</td></tr>
            <tr><td><strong>Isabella Chen</strong><div class="small text-secondary">isabella@example.com</div></td><td>#ORD-1046</td><td>20 Oct 2026</td><td><span class="rai-badge rai-badge-danger">Cancelled</span></td><td>$89.00</td></tr>
        </tbody></table></div>
    </x-admin-ui::card>
@endsection
