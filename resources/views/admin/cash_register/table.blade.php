<tr data-id="{{ $entry->date . $entry->store_id }}">
	<td>{{ $entry->date->format('j M Y') }}</td>
	<td>{{ $entry->income }} лв.</td>
	<td>{{ $entry->expenses }} лв.</td>
	<td>{{ $entry->total }} лв.</td>
</tr>