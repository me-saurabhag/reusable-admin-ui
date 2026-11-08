@props(['title' => 'No records found', 'description' => 'There are no records to display right now.', 'colspan' => 1])
<tr class="rai-table-empty-row">
    <td colspan="{{ max(1, (int) $colspan) }}">
        <div class="rai-table-empty">
            @isset($icon)<div class="rai-table-empty__icon">{{ $icon }}</div>@else<div class="rai-table-empty__icon" aria-hidden="true">⌕</div>@endisset
            <div class="rai-table-empty__title">{{ $title }}</div>
            <div class="rai-table-empty__description">{{ $description }}</div>
            @isset($action)<div class="rai-table-empty__action">{{ $action }}</div>@endisset
        </div>
    </td>
</tr>
