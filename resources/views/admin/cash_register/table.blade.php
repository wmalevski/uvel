<tr data-id="{{ $entry->date . $entry->store_id }}">
	<td>{{ $entry->date->format('j M Y') }}</td>
	<td>{{ number_format($entry->income * getCurrencyRate('EUR')), 2 }} €</td>
	<td>{{ number_format($entry->expenses * getCurrencyRate('EUR')), 2 }} €</td>
	<td>{{ number_format($entry->total * getCurrencyRate('EUR')), 2 }} €</td>
</tr>