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
                            <select name="product_select" class="form-control" data-url="ajax/productstravelling/addByScan/" data-search="/ajax/select_search/products/" data-search-param-name="byCode">
                                <option value="">Избери продукт</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <table class="table repair-records-table tablesort">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Баркод</th>
                                        <th scope="col">Име</th>
                                        <th scope="col">Грамаж</th>
                                        <th scope="col">Действия</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Общо</th>
                                        <th></th>
                                        <th id="travellingCounter">Брой: <b>0</b></th>
                                        <th id="travellingWeight">Тегло: <b>0</b> гр.</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="3">Магазин: </label>
                            <select name="store_to_id" class="form-control" data-search="/ajax/select_search/stores/">
                                <option value="">Избери магазин</option>
                            </select>
                        </div>
                    </div>

                </div>

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
                <div class="form-group col-md-6">
                    <label>Сканирай: </label>
                    <input id="barcodeScanAccept" type="text" class="form-control" name="product_accept_barcode" placeholder="Приеми продукт" data-url="/ajax/productstravelling/accept/">
                </div>
              <table id="main_table" class="table table-condensed">
                <thead>
                    <tr data-sort-method="none">
                        <th width="10%">Снимка</th>
                        <th width="15%">Уникален номер</th>
                        <th width="5%">Тегло</th>
                        <th width="15%">Изпратен на</th>
                        <th width="15%">Приеми продукт</th>
                        <th width="15%">От магазин</th>
                        <th width="15%">До магазин</th>
                        <th width="5%">Статус</th>
                        <th width="5%" data-sort-method="none"></th>
                    </tr>
                </thead>

                <tbody>
                @foreach($travelling as $product)
                    @if( in_array($loggedUser->role,array('admin','storehouse')) || $product->store_to_id == $loggedUser->store_id )
                        @include('admin.products_travelling.table')
                    @endif
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
</div>
@endsection
@section('footer-scripts')
<style>
    table thead th{color:silver;}
</style>
<script type="text/javascript">
    $(document).ready(function(){
        $("table.repair-records-table.tablesort tbody").bind("DOMSubtreeModified", function(){
            $('table.repair-records-table.tablesort tfoot tr th#travellingCounter b').html($("table.repair-records-table.tablesort tbody tr").length);

            weightCounter = 0;
            $("table.repair-records-table.tablesort tbody tr").each(function(index,row){
                weightCounter += parseFloat($(row).children('td:nth-child(4)').html().replace(' гр', ''));
            });
            $('table.repair-records-table.tablesort tfoot tr th#travellingWeight b').html(weightCounter);
        });
    });
</script>
@endsection