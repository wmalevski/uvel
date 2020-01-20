@extends('admin.layout')

@section('content')
<div class="modal fade" id="addNomenclature" role="dialog" aria-labelledby="addNomenclatureLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNomenclatureLabel">Добавяне на номенклатура</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="nomenclatures" data-type="add" action="nomenclatures">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на номенклатура:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button btn btn-primary add-btn-modal">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editNomenclature" tabindex="-1"  role="dialog" aria-labelledby="editNomenclature">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Номенклатури <button type="button" class="btn btn-primary" data-form-type="add" data-form="nomenclatures" data-toggle="modal" data-target="#addNomenclature">Добави</button></h4>
            <p>Преглед на създадените размери.</p>
            <table id="main_table" class="table table-condensed tablesort">
                <thead>
                    <tr>
                        <th>Име</th>
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            <th data-sort-method="none">Действия</th>
                        @endif
                    </tr>
                </thead>
               <tbody>
                    @foreach($nomenclatures as $nomenclature)
                        @include('admin.nomenclatures.table')
                    @endforeach
               </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
