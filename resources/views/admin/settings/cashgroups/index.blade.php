@extends('admin.layout')

@section('content')
<div class="modal fade edit--modal_holder" id="editCashGroup" tabindex="-1"  role="dialog" aria-labelledby="editCashGroup">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Касови групи</h4>

            <p>Преглед на касовите групи.</p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">За</th> 
                  <th scope="col">Касова група</th>
                  <th scope="col">Действия</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cashgroups as $cashgroup)
                    @include('admin.settings.cashgroups.table')
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

@endsection