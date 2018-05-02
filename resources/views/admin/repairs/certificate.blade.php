{{-- {!! DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true) !!} --}}

<!DOCTYPE html>
<html lang="en-US">
  <head>
  <meta charset="utf-8" />
  <title>Uvel</title>
  </head>
  <body>
    <h2 style="text-align: center;">Магазин за златна и сребърна бижутерия</h1>
    <h2 style="text-align: center;">ул. "Позитано" №20</h1>
    <h2 style="text-align: center;">Тел: 0887977322</h1>
    <hr/>

    <h1 style="text-align: center;"><strong>РЕМОНТ №: {{ $repair->id }}</strong></h1>
    <h2 style="text-align: center;">бижутерско изделие</h2>

    <div>
        <strong>Клиент: </strong> {{ $repair->customer_name }}
    </div>
    <hr/>

    <div>
        <strong>Тел: </strong> {{ $repair->customer_phone }}
    </div>
    <hr/>

    <div>
        <strong>Опис: </strong> {{ $repair->repair_description }}
    </div>
    <hr/>

    <div>
        <strong>Цена: </strong> {{ $repair->price }} 
        <strong style="margin-left: 50px;">Капаро: </strong> {{ $repair->deposit }}
        <strong style="margin-left: 50px;">Остатък: </strong> {{ $repair->price-$repair->deposit }}
    </div>
    <hr/>

    <div>
        <strong>Клиент: </strong>
        <strong style="margin-left: 200px;">Приемчик: </strong>
    </div>
    <hr/>

    <div>
        <strong>Дата за получаване: </strong> {{ $repair->date_returned }} 
    </div>
    <hr/>

  </body>
</html>