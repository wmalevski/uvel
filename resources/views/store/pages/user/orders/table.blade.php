<tr>
  <td>{{ $order->id }}</td>
  <td>{{ $order->store_id }}</td>
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
    <button data-toggle="collapse" data-target="#accordion{{ $order->id }}" class="btn btn-1">Преглед</button>
  </td>
</tr>
<tr id="accordion{{ $order->id }}" class="collapse">
  <td colspan="10">
    <div class="row float-right col-md-12">
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">Артикул</th>
            <td>Хонда</td>
          </tr>
          <tr>
            <th scope="row">Брой/Количество</th>
            <td>10</td>
          </tr>
          <tr>
            <th scope="row">Цена</th>
            <td>20лв</td>
          </tr>
          <tr>
            <th scope="row">Изработка</th>
            <td>50лв</td>
          </tr>
        </tbody>
      </table>
      
      <table class="table">
        <tbody>
          <tr>
            <th scope="row">Артикул</th>
            <td>БМВ</td>
          </tr>
          <tr>
            <th scope="row">Брой/Количество</th>
            <td>2</td>
          </tr>
          <tr>
            <th scope="row">Цена</th>
            <td>230лв</td>
          </tr>
          <tr>
            <th scope="row">Изработка</th>
            <td>100лв</td>
          </tr>
        </tbody>
      </table>
    </div>
  </td>
</tr>
