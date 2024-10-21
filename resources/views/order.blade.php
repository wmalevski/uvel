<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background-color: #bf8f00;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-content {
            padding: 20px;
        }
        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        a.button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <header class="email-header">
            <h1>Нова поръчка</h1>
        </header>

        <main class="email-content">
            @if(isset($ID))
            <section>
                <p>ID: <strong>{{ $ID }}</strong></p>
            </section>
            @endif

            @if(isset($name))
            <section>
                <p>Име: <strong>{{ $name }}</strong></p>
            </section>
            @endif

            @if(isset($city))
            <section>
                <p>Град: <strong>{{ $city }}</strong></p>
            </section>
            @endif

            @if(isset($phone))
            <section>
                <p>Телефон: <strong>{{ $phone }}</strong></p>
            </section>
            @endif

            @if(isset($email))
            <section>
                <p>Email: <strong>{{ $email }}</strong></p>
            </section>
            @endif

            @if(isset($content))
            <section>
                <p>Описание: <strong>{{ $content }}</strong></p>
            </section>
            @endif

            @if(isset($size))
            <section>
                <p>Размер: <strong>{{ $size }}</strong></p>
            </section>
            @endif

            @if(isset($unique_number))
            <section>
                <p>Уникален номер: <strong>{{ $unique_number }}</strong></p>
            </section>
            @endif

            @if(isset($weight))
            <section>
                <p>Тегло: <strong>{{ $weight }}</strong></p>
            </section>
            @endif

            @if(isset($type))
            <section>
                <p>Бижу: <strong>{{ $type }}</strong></p>
            </section>
            @endif

            @if(isset($archive_date))
            <section>
                <p>Дата на архив: <strong>{{ Carbon\Carbon::parse($archive_date)->format('y m d') }}</strong></p>
            </section>
            @endif

            @if(isset($shipping_method))
            <section>
                <p>Метод на доставка: <strong>{{ $shipping_method }}</strong></p>
                @if($shipping_method == 'store')
                    <ul>
                        <li>Магазин: <strong></strong>{{ $store['name'] }}</strong></li>
                        <li>Локация: <strong></strong>{{ $store['location'] }}</strong></li>
                    </ul>
                @endif
            </section>
            @endif

            @if(isset($shipping_address))
            <section>
                <p>Адрес:</p>
                <ul>
                    <li>Град: <strong>{{$shipping['city']}}</strong></li>
                    <li>Улица: <strong>{{$shipping['street']}}</strong></li>
                    <li>Улица #: <strong>{{$shipping['street_number']}}</strong></li>
                    <li>Пощенски код: <strong>{{$shipping['postcode']}}</strong></li>
                    <li>Телефон: <strong>{{$shipping['phone']}}</strong></li>
                </ul>
            </section>
            @endif

            @if(isset($cart_items))
            <section>
                <p>Количка : </p>
                @if(is_array($cart_items))
                    @foreach($cart_items as $i)
                        <ul>
                            <li>ID на артикула: <strong>{{ $i['attributes']['product_id'] }}</strong></li>
                            <ul>
                                <li>Име: <strong>{{ $i['name'] }}</strong></li>
                                <li>Количество: <strong>{{ $i['quantity'] }}бр.</strong></li>
                                <li>Цена: <strong>{{ $i['price'] }}лв.</strong></li>
                            </ul>
                        </ul>
                    @endforeach
                @endif
            </section>
            @endif
        </main>

        <footer class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply.</p>
        </footer>
    </div>
</body>
</html>
