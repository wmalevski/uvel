<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="editDiscountLabel">Информация за дневен отчет</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <form method="POST" name="dailyReports" data-type="edit" action="dailyreports/{{ $report->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">
            <div class="info-cont"></div>
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="1">Магазин: </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="1" name="store_id" value="{{ $report->store->name }}" readonly>
                    </div>
                </div>
    
                <div class="form-group col-md-6">
                    <label for="inputZip">Подаден на:</label>
                    <div class="input-group">
                        
                        <input type="text" name="date_expires" class="form-control" value="{{ $report->created_at }}" readonly>
                    </div>
                </div>
            </div>

            @if($report->type == 'money')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="1">Сума от системата: </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="safe_money_amount" value="{{ $report->safe_money_amount }}" readonly>
                        </div>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="inputZip">Въведена от касата:</label>
                        <div class="input-group">
                            
                            <input type="text" name="given_money_amount" class="form-control" value="{{ $report->given_money_amount }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Купюра:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Брой:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Стойност в лв.</label>
                    </div>
                </div>
                @foreach($report->report_banknotes as $banknote)
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="banknote" value="{{ $banknote->banknote }}"
                                       readonly>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" name="quantity"
                                       value="{{ $banknote->quantity }}" readonly>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="input-group">
                                <input type="text" name="calculated_quantity" class="form-control"
                                       value=" {{ $banknote->banknote*$banknote->quantity }}" readonly>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Валута:</label>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Стойност:</label>
                    </div>
                </div>
                @foreach($report->report_currencies as $currency)
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="currency"
                                   value="{{ $currency->currency->name }}" readonly>
                        </div>

                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="quantity"
                                   value="{{ $currency->quantity }}" readonly>
                        </div>
                    </div>
                @endforeach
            @elseif($report->type == 'jewels')
                @if ($jewels = App\DailyReportJewel::where('report_id',$report->id))
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="1">Материал:</label>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="1">Брой:</label>
                        </div>
                    </div>
                    @foreach($jewels->get() as $jewel)
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="material_id" value="{{ \App\Material::find($jewel->material_id)->name }} - {{ \App\Material::find($jewel->material_id)->code  }} - {{ \App\Material::find($jewel->material_id)->color  }}" readonly>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="quantity" value="{{ $jewel->quantity}}" readonly>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="1">Стойност: </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="fiscal_amount" value="{{ $report->fiscal_amount }}" readonly>
                        </div>
                    </div>
                </div>
            @elseif($report->type == 'materials')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="1">Материал:</label>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="1">Количество:</label>
                    </div>
                </div>
                @foreach($report->report_materials as $material)
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="material_id" value="{{  $material->material->material->parent->name . ' - ' . $material->material->material->code . ' - ' .  $material->material->material->color }}" readonly>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" name="quantity"
                                       value="{{ $material->quantity }}" readonly>
                                <span class="input-group-addon">гр.</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div id="errors-container"></div>
        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        </div>
    </form>
    </div>
