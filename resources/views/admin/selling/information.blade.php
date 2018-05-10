
    <h2 style="text-align: center;">Магазин за златна и сребърна бижутерия</h2>
    <h2 style="text-align: center;">ул. "Позитано" №20</h2>
    <h2 style="text-align: center;">Тел: 0887977322</h2>

    <h2 style="text-align: center;">Разписка за продадена стока</h2>

    <div style="text-align: center; font-size: 17px; font-weight: bold;">{{ Carbon\Carbon::now() }}</div>

    <br/>

    <table class="table" id="shopping-table">
        <thead>
            <tr>
                <th scope="col">Артикул</th>
                <th scope="col">Брой</th>
                <th scope="col">Грам</th>
                <th scope="col">Цена</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</th>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->attributes->weight }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr/>

    <div style="text-align: right">
        <h3>Общо: {{ $total }}</h3>
    </div>

    Печат: 
