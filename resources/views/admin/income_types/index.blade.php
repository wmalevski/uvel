@extends('admin.layout')

@section('content')
<div class="modal fade add--modal_holder" id="addIncomeModal" role="dialog" aria-labelledby="addIncomeModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<div class="modal fade edit--modal_holder" id="editIncomeType" role="dialog" aria-labelledby="editIncomeType"
aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="bgc-white bd bdrs-3 p-20 mB-20">
			<h4 class="c-grey-900 mB-20">Видове Приходи
			<button data-url="income_types/create" type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addIncomeModal" data-form-type="add" data-form="incomeTypes">Добави</button></h4>
			<p>Преглед на създадените видове Приходи.</p>
			<table id="main_table" class="table">
				<thead>
					<tr>
						<th scope="col">Име</th>
						<th scope="col" data-sort-method="none">Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach($incomeTypes as $type)
						@include('admin.income_types.table')
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection