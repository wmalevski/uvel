@extends('admin.layout')

@section('content')
    <div id='mainContent'>
      <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-4"></div>
        <div class="masonry-item col-md-4">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Парични дневни преводи</h6>
            <div class="mT-30">
                <form method="POST" action="create/moneyreport">
                  @if(session()->has('success.money'))
                    <div class="alert alert-success">
                      {{ session()->get('success.money') }}
                    </div>
                  @endif
                  @if($errors->form_money->any())
                    <ul class="alert alert-danger">
                      @foreach ($errors->form_money->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                  </ul>
                    @endif
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label>Купюра</label>
                        <input type="text" class="form-control" name="banknote[]" value="100" placeholder="100" readonly>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Брой</label>
                        <input type="text" class="form-control" name="quantity[]" placeholder="0">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputtext4">Стойност в лв.</label>
                        <input type="text" class="form-control" placeholder="0">
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="50" placeholder="50" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="20" placeholder="20" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="10" placeholder="10" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="5" placeholder="5" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="2" placeholder="2" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="1" placeholder="1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="0.5" placeholder="0.5" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="0.2" placeholder="0.2" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="0.1" placeholder="0.1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="00.2" placeholder="00.2" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="banknote[]" value="00.1" placeholder="00.1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" name="quantity[]" placeholder="0">
                        </div>
                        <div class="form-group col-md-4">
                          <input type="text" class="form-control" placeholder="0">
                        </div>
                      </div>

                      @foreach($currencies as $currency)
                        <div class="form-row">
                          <div class="form-group col-md-4">
                          </div>
                          <div class="form-group col-md-4">
                            <input type="text" class="form-control" value="{{ $currency->name }}" placeholder="0" readonly>
                            <input type="hidden" class="form-control" name="currency_id[]" value="{{ $currency->id }}">
                          </div>
                          <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="quantity[]" placeholder="0">
                          </div>
                        </div>
                      @endforeach
                    <button type="submit" class="btn btn-primary">Пускане</button>
                  </form>
            </div>
          </div>
        </div>
        <div class="masonry-item col-md-4">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Дневен отчет бижута</h6>
            <div class="mT-30">
                <form method="POST" action="create/jewelreport">
                  @if(session()->has('success.jewels'))
                    <div class="alert alert-success">
                      {{ session()->get('success.jewels') }}
                    </div>
                  @endif
                  @if($errors->form_jewels->any())
                    <ul class="alert alert-danger">
                      @foreach ($errors->form_jewels->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  @endif

                  @foreach($materials as $material)
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Материал</label>
                            <input type="number" class="form-control" placeholder="{{ $material->material->parent->name }}" readonly>
                            <input type="hidden" class="form-control" value="{{ $material->id }}" name="material_id[]">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputtext4">Брой</label>
                            <input type="number" name="quantity[]" class="form-control" placeholder="0">
                        </div>
                    </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary">Пускане</button>
                </form>
            </div>
          </div>
        </div>
        <div class="masonry-item col-md-4">
          <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Дневен отчет материали</h6>
            <div class="mT-30">
              <form method="POST" action="create/materialreport">
                @if(session()->has('success.materials'))
                  <div class="alert alert-success">
                    {{ session()->get('success.materials') }}
                  </div>
                @endif
                @if($errors->form_materials->any())
                  <ul class="alert alert-danger">
                    @foreach ($errors->form_materials->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                @endif

                @foreach($materials as $material)
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Материал</label>
                            <input type="number" class="form-control" placeholder="{{ $material->material->parent->name }} - {{ $material->material->carat }}" readonly>
                            <input type="hidden" class="form-control" value="{{ $material->id }}" name="material_id[]">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputtext4">Количество гр.</label>
                            <input type="number" name="quantity[]" class="form-control" placeholder="0">
                        </div>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary">Пускане</button>
              </form>  
            </div>
          </div>
        </div>
      </div>
    </div>
    @endsection