<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Благодарим за вашата поръчка</title>
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
            <h1>Uvel поръчка</h1>
        </header>

        <main class="email-content">
            <section>
                <p>Здравейте, <strong>{{$name}}</strong>,</p>
                {{-- <p>Вашата поръчка <strong>No: {{$order->id}}</strong> е получена и в момента се обработва.</p> --}}
                <p>Вашата поръчка е получена и в момента се обработва.</p>
            </section>

            <section>
                <h2>Детайли на поръчката</h2>
                <ul>
                    <li><strong>Плащане:</strong> В брой при доставка</li>
                    <li><strong>Начин на плащане:</strong> Наложен платеж</li>

                    @if(isset($cart_items))
                        <li><strong>Количка:</strong></li>
                        @if(is_array($cart_items))
                            @foreach($cart_items as $i)
                                <ul>
                                    <li><strong>Продукт No:</strong> {{ $i['attributes']['product_id'] }}</li>
                                    <li><strong>Модел:</strong> {{ $product_names[$loop->iteration-1] }}</li>
                                    <li><strong>Количество:</strong> {{ $i['quantity'] }}бр.</li>
                                    @if( array_key_exists('weight', $i) && !is_null($i['weight']) )
                                        <li><strong>Тегло:</strong> {{ $i['weight'] }} гр.</li>
                                    @endif
                                    <li><strong>Цена:</strong> {{ $i['price'] }}лв.</li>
                                </ul>
                                <hr>
                            @endforeach
                        @endif
                    @endif
                </ul>
            </section>
        </main>

        <footer class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated message. Please do not reply.</p>
        </footer>
    </div>
</body>
</html>
