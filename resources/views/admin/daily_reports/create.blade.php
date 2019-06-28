@extends('admin.layout')
@section('content')
<div id='mainContent'>
  <div class="row gap-20 masonry pos-r daily-report-create-page">
    <div class="masonry-sizer col-md-4"></div>
    <div class="masonry-item col-md-4">
      <div class="bgc-white p-20 bd">
        <h6 class="c-grey-900">Дневен отчет пари</h6>
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
              </div>
              <div class="form-group col-md-4">
                <label>Брой</label>
              </div>
              <div class="form-group col-md-4">
                <label for="inputtext4">Стойност в лв.</label>
              </div>
            </div>

            @foreach(config('constants.DENOMINATIONS') as $denomination)
              <div class="form-row">
                <div class="form-group col-md-4">
                  <input class="input-denomination form-control" type="number" data-row="{{ $denomination }}" 
                         name="banknote[]" value="{{ $denomination }}" placeholder="{{ $denomination }}" readonly>
                </div>
                <div class="form-group col-md-4">
                  <input class="input-quantity form-control" type="number" min="0" data-row="{{ $denomination }}"
                         name="quantity[]" placeholder="0">
                </div>
                <div class="form-group col-md-4">
                  <input class="input-total form-control" type="number" data-row="{{ $denomination }}"
                         placeholder="0" readonly>
                </div>
              </div>
            @endforeach

            @foreach($currencies as $currency)
              <div class="form-row">
                <div class="form-group col-md-4">
                </div>
                <div class="form-group col-md-4">
                  <input type="text" class="form-control" value="{{ $currency->name }}" placeholder="0" readonly>
                  <input type="hidden" class="form-control" name="currency_id[]" value="{{ $currency->id }}">
                </div>
                <div class="form-group col-md-4">
                  <input type="number" class="form-control" min="0" step="1" name="quantity[]" placeholder="0">
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
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Материал</label>
              </div>
              <div class="form-group col-md-6">
                <label for="inputtext4">Брой</label>
              </div>
            </div>

            @foreach($materials as $material)
            <div class="form-row">
              <div class="form-group col-md-6">
                <input type="number" class="form-control" placeholder="{{ $material->name }} - {{ $material->color }} - {{ $material->code }}" readonly>
                <input type="hidden" class="form-control" value="{{ $material->id }}" name="material_id[]">
              </div>
              <div class="form-group col-md-6">
                <input type="number" min="0" name="quantity[]" class="form-control" placeholder="0">
              </div>
            </div>
            @endforeach

            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Стойност</label> 
                <input type="number" class="form-control" min="0" placeholder="0" name="fiscal_amount">
              </div>
            </div>
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
            
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Материал</label>
              </div>
              <div class="form-group col-md-6">
                <label>Количество гр.</label>
              </div>
            </div>

            @foreach($materials as $material)
            <div class="form-row">
              <div class="form-group col-md-6">
                
                <input type="number" class="form-control" placeholder="{{ $material->name }} - {{ $material->color }} - {{ $material->code }}" readonly>
                <input type="hidden" class="form-control" value="{{ $material->id }}" name="material_id[]">
              </div>
              <div class="form-group col-md-6">
                <input type="number" min="0" name="quantity[]" class="form-control" placeholder="0">
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
