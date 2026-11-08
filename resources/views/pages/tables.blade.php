<x-admin-ui::layout title="Tables">
<div class="rai-pattern-page rai-table-page">
    <header class="rai-pattern-page__header">
        <div>
            <div class="rai-pattern-page__eyebrow">COMPONENTS / DATA DISPLAY</div>
            <h1 class="rai-pattern-page__title">Tables</h1>
            <p class="rai-pattern-page__description">Flexible, content-first tables for contacts, messages, transactions and other host application data.</p>
        </div>
        <span class="rai-pattern-page__version">v0.4.0</span>
    </header>

    <div class="rai-table-demo-stack">
        <section class="rai-pattern-card">
            <div class="rai-pattern-card__header"><h2>01. Default table — Contacts</h2><p>Host application supplies the columns, row content, badges and actions.</p></div>
            <div class="rai-pattern-card__body">
                <x-admin-ui::table appearance="default" size="md">
                    <x-slot:heading>All contacts</x-slot:heading>
                    <x-slot:description>Manage people saved in your workspace.</x-slot:description>
                    <x-slot:actions><x-admin-ui::button size="sm" variant="primary">+ Add contact</x-admin-ui::button></x-slot:actions>
                    <x-slot:header>
                        <tr><th>Name</th><th>Phone</th><th>Source</th><th>Status</th><th class="text-end">Actions</th></tr>
                    </x-slot:header>
                    <tr>
                        <td><div class="rai-table-person"><span class="rai-table-avatar">AS</span><div><div class="rai-table-person__name">Aarav Sharma</div><div class="rai-table-person__meta">aarav@example.com</div></div></div></td>
                        <td>+91 98765 43210</td><td>Website</td><td><x-admin-ui::badge variant="success">Active</x-admin-ui::badge></td><td class="text-end"><x-admin-ui::button size="xs" appearance="ghost">View</x-admin-ui::button></td>
                    </tr>
                    <tr>
                        <td><div class="rai-table-person"><span class="rai-table-avatar rai-table-avatar--blue">PM</span><div><div class="rai-table-person__name">Priya Mehta</div><div class="rai-table-person__meta">priya@example.com</div></div></div></td>
                        <td>+91 91234 56780</td><td>WhatsApp</td><td><x-admin-ui::badge variant="warning">Pending</x-admin-ui::badge></td><td class="text-end"><x-admin-ui::button size="xs" appearance="ghost">View</x-admin-ui::button></td>
                    </tr>
                    <tr>
                        <td><div class="rai-table-person"><span class="rai-table-avatar">RK</span><div><div class="rai-table-person__name">Rohan Kapoor</div><div class="rai-table-person__meta">rohan@example.com</div></div></div></td>
                        <td>+91 99887 76655</td><td>Import</td><td><x-admin-ui::badge variant="danger">Blocked</x-admin-ui::badge></td><td class="text-end"><x-admin-ui::button size="xs" appearance="ghost">View</x-admin-ui::button></td>
                    </tr>
                    <x-slot:footer><span class="rai-table-muted" style="font-size:12px">Sample data · pagination can be placed below the table.</span></x-slot:footer>
                </x-admin-ui::table>
            </div>
        </section>

        <section class="rai-pattern-card">
            <div class="rai-pattern-card__header"><h2>02. Compact table — Messages</h2><p>Higher information density for activity-heavy screens.</p></div>
            <div class="rai-pattern-card__body">
                <x-admin-ui::table appearance="default" size="sm" striped>
                    <x-slot:heading>Recent messages</x-slot:heading>
                    <x-slot:description>Latest incoming and outgoing messages.</x-slot:description>
                    <x-slot:header><tr><th>Contact</th><th>Message</th><th>Direction</th><th>Time</th></tr></x-slot:header>
                    <tr><td><strong>Aarav Sharma</strong></td><td>Thank you, received the details.</td><td><x-admin-ui::badge variant="success">Incoming</x-admin-ui::badge></td><td class="rai-table-muted">10:42 AM</td></tr>
                    <tr><td><strong>Priya Mehta</strong></td><td>Your appointment is confirmed.</td><td><x-admin-ui::badge variant="info">Outgoing</x-admin-ui::badge></td><td class="rai-table-muted">10:35 AM</td></tr>
                    <tr><td><strong>Rohan Kapoor</strong></td><td>Can you share the invoice?</td><td><x-admin-ui::badge variant="success">Incoming</x-admin-ui::badge></td><td class="rai-table-muted">10:18 AM</td></tr>
                </x-admin-ui::table>
            </div>
        </section>

        <section class="rai-pattern-card">
            <div class="rai-pattern-card__header"><h2>03. Bordered table — Transactions</h2><p>Clear cell boundaries for structured numeric data.</p></div>
            <div class="rai-pattern-card__body">
                <x-admin-ui::table appearance="bordered" size="md" :hoverable="false">
                    <x-slot:heading>Recent transactions</x-slot:heading>
                    <x-slot:header><tr><th>Reference</th><th>Date</th><th>Amount</th><th>Status</th></tr></x-slot:header>
                    <tr><td>#TXN-2048</td><td>06 Nov 2026</td><td><strong>₹2,450.00</strong></td><td><x-admin-ui::badge variant="success">Paid</x-admin-ui::badge></td></tr>
                    <tr><td>#TXN-2047</td><td>05 Nov 2026</td><td><strong>₹890.00</strong></td><td><x-admin-ui::badge variant="warning">Processing</x-admin-ui::badge></td></tr>
                </x-admin-ui::table>
            </div>
        </section>

        <section class="rai-pattern-card">
            <div class="rai-pattern-card__header"><h2>04. Empty state</h2><p>Use the empty-state row when a query returns no records.</p></div>
            <div class="rai-pattern-card__body">
                <x-admin-ui::table>
                    <x-slot:heading>Automation logs</x-slot:heading>
                    <x-slot:header><tr><th>Event</th><th>Automation</th><th>Date</th></tr></x-slot:header>
                    <x-admin-ui::table-empty-state colspan="3" title="No activity yet" description="When an automation runs, its activity will appear here." />
                </x-admin-ui::table>
            </div>
        </section>

        <section class="rai-pattern-card">
            <div class="rai-pattern-card__header"><h2>05. Usage example</h2><p>Pass Laravel data through the default slot; the package does not know your models or database schema.</p></div>
<div class="rai-pattern-card__body">
    @verbatim
    <pre class="rai-table-code"><code><x-admin-ui::table appearance="default" size="md">
    <x-slot:heading>Contacts</x-slot:heading>

    <x-slot:header>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Status</th>
        </tr>
    </x-slot:header>

    @foreach ($contacts as $contact)
        <tr>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->phone }}</td>
            <td>{{ $contact->status }}</td>
        </tr>
    @endforeach
</x-admin-ui::table>

<x-admin-ui::pagination :paginator="$contacts" /></code></pre>
    @endverbatim
</div>
        </section>
    </div>
</div>
</x-admin-ui::layout>
