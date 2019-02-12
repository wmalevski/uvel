@extends('store.layouts.app', ['bodyClass' => 'templateCustomersRegister'])

@section('content')

<div id="content-wrapper-parent">
  <div id="content-wrapper">
    <div id="content" class="clearfix">
      <div id="breadcrumb" class="breadcrumb">
        <div itemprop="breadcrumb" class="container">
          <div class="row">
            <div class="col-md-24">
              {{ Breadcrumbs::render('model_orders') }}
            </div>
          </div>
        </div>
      </div>
      <section class="content page-store-orders">
        <div class="container">
          <div class="row">
            <div id="page-header" class="col-md-24">
              <h1 id="page-title">Поръчка #5129075109</h1>
            </div>

            <div class="row">
              <div class="store-order-block col-md-8">
                <strong>Материал</strong>
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th scope="row">Вид</th>
                      <td>Злато - Жълто - 525</td>
                    </tr>
                    <tr>
                      <th scope="row">Цена</th>
                      <td>Продава 1 - 90лв</td>
                    </tr>
                    <tr>
                      <th scope="row">Нетно тегло</th>
                      <td>241гр</td>
                    </tr>
                    <tr>
                      <th scope="row">Размер</th>
                      <td>44</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="store-order-block col-md-8">
                <strong>Материал</strong>
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th scope="row">Вид</th>
                      <td>Злато - Жълто - 525</td>
                    </tr>
                    <tr>
                      <th scope="row">Цена</th>
                      <td>Продава 1 - 90лв</td>
                    </tr>
                    <tr>
                      <th scope="row">Нетно тегло</th>
                      <td>241гр</td>
                    </tr>
                    <tr>
                      <th scope="row">Размер</th>
                      <td>44</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row">
              <div class="store-order-block col-md-8">
                <strong>Даден материал</strong>
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th scope="row">Вид</th>
                      <td>Злато - Жълто - 525</td>
                    </tr>
                    <tr>
                      <th scope="row">Количество</th>
                      <td>80гр</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row">
            <div class="store-order-block col-md-8">
              <strong>Капаро</strong>
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th scope="row">Сума</th>
                    <td>1700лв</td>
                  </tr>
                </tbody>
              </table>
              </div>
            </div>

          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
