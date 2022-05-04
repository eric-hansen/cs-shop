<p class="text-sm text-gray-700 leading-5 dark:text-white">
    <strong>{{ __('Sales Total') }}</strong>: $@currency($total)<br />
    <strong>{{ __('Sales Average') }}</strong>: $@currency($avg)<br />
    
    @if($status_totals->isNotEmpty())
    <strong>{{ __('Status Breakdown') }}</strong>: {{ $status_totals->join(", ") }}
    @endif
</p>