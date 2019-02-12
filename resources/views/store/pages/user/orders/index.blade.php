@extends('store.layouts.app', ['bodyClass' => 'templateCustomersRegister'])

@section('content')

<div id="content-wrapper-parent" class="page-store-orders">
  <div id="content-wrapper">
    <!-- Content -->
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
      <section class="content">
        <div class="container">
          <div class="row">
            <div id="page-header" class="col-md-24">
              <h1 id="page-title">Поръчки</h1>
            </div>

            <div id="col-main" class="col-md-24 clearfix">
              <table class="table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Поръчано от</th>
                    <th scope="col">Модел</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действия</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($orders as $order)
                    @include('store.pages.user.orders.table')
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
