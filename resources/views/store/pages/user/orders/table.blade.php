<tr>
  <td>{{ $order->user->name }}</td>
  <td>{{ $order->user->email }}</td>
  <td>{{ $order->user->phone }}</td>
  <td>{{ $order->user->city }}</td>
  <td>{{ $order->model->name }}</td>
  <td>{{ $order->created_at }}</td>
  <td>
    @if($order->status == 'pending')
    <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Очаква
      одобрение</span>
    @elseif($order->status == 'accepted')
    <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Приет/В процес</span>
    @elseif($order->status == 'ready')
    <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Върнат от работилница</span>
    @else
    <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Получен</span>
    @endif
  </td>
  <td>
    <!-- href="{{ route('single_order') }}"  -->
    <a data-toggle="collapse" data-target="#accordion{{ $order->id }}" class="clickable">Преглед</a>
  </td>
</tr>
<tr id="accordion{{ $order->id }}" class="collapse">
  <td colspan="10">
    <div class="row store-order-block col-md-12">
      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row">Артикул</th>
            <td>Продукт</td>
          </tr>
          <tr>
            <th scope="row">Количество</th>
            <td>Брой</td>
          </tr>
          <tr>
            <th scope="row">Цена</th>
            <td>Изработка</td>
          </tr>
        </tbody>
      </table>

      <strong>Материал</strong>
      <table class="table table-striped">
        <tbody>
          <tr>
            <th scope="row">Име</th>
            <td>Сребро</td>
          </tr>
          <tr>
            <th scope="row">Цена</th>
            <td>70лв</td>
          </tr>
          <tr>
            <th scope="row">Тегло</th>
            <td>80гр</td>
          </tr>
          <tr>
            <th scope="row">Размер</th>
            <td>15</td>
          </tr>
        </tbody>
      </table>
    </div>
  </td>
</tr>
