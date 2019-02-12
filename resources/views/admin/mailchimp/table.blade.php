<tr data-id="{{ $subscriber['email_address'] }}">
    <td>{{ $subscriber['email_address'] }}</td> 
    <td>
        @if($subscriber['status'] == 'subscribed')
            <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Абониран</span>
        @else 
            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Не абониран</span>
        @endif
    </td>
    <td>
        <span data-url="mailchimp/unsubscribe/{{$subscriber['email_address']}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>