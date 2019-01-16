@extends('admin.layout')

@section('content')
<div class="modal fade" id="sendProduct"   role="dialog" aria-labelledby="sendProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendProductLabel">Изпращане на продукт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="productsTravelling" data-type="add" action="productstravelling" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Сканирай: </label>
                            <input id="inputBarcodeScan" type="text" class="form-control" name="product_barcode" placeholder="Сканирай продукт" data-url="ajax/productstravelling/addByScan/">
                        </div>

                        <div class="form-group col-md-6">
                        <label>Избери: </label>
                            <select name="product_select[]" class="form-control" data-url="ajax/productstravelling/addByScan/">
                                <option value="">Избери продукт</option>

                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-product-id="{{ $product->id }}" data-barcode="{{ $product->barcode }}" data-weight="{{ $product->weight }}">
                                       {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <table class="table repair-records-table tablesort">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Баркод</th>
                                    <th scope="col">Име</th>
                                    <th scope="col">Грамаж</th>
                                    <th scope="col">Действия</th>
                                </tr>
                            </thead>
                            <tbody id="foundProducts"></tbody>
                        </table>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Магазин: </label>
                            <select name="store_to_id" class="form-control">
                                <option value="">Избери магазин</option>

                                @foreach($stores as $store)
                                    @if($store->id != Auth::user()->getStore()->id)
                                        <option value="{{ $store->id }}">
                                            {{ $store->name }} - {{ $store->location }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="store_id" value="{{  Auth::user()->store }}">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Продукти на път
                    <button type="button" class="btn btn-primary" data-form-type="add" data-form="productsTravelling" data-toggle="modal" data-target="#sendProduct">Изпрати</button>
              </h4>
              <p>Преглед на пътуващите продукти.</p>
              <table class="table table-condensed">
                  <tr>
                      <th>Продукт</th>
                      <th>Изпратен на</th>
                      <th>От магазин</th>
                      <th>До магазин</th>
                      <th>Статус</th>
                      <th></th>
                  </tr>

                  @foreach($travelling as $product)
                      @include('admin.products_travelling.table')
                  @endforeach
              </table>
            </div>
          </div>
</div>
@endsection
