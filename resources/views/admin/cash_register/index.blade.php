@extends('admin.layout')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bgc-white bd bdrs-3 p-20 mB-20">
			<h4 class="c-grey-900 mB-20">Движения</h4>
			<p>Преглед на въведените приходи и разходи.</p>

			@if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
				<div class="row" data-filter="cash_register" data-report-key="cash_register">
					<div class="col-md-10">
						<div class="timepicker-input input-icon form-group">
							<div class="input-group">
								<select name="store_selector" id="store_selector" class="form-control">
								@foreach($stores as $store)
								<option value="{{ $store->id }}"
									@if ($store->id == $def_store)
										selected="selected"
									@endif
								>{{ $store->name }} - {{ $store->location }}</option>
								@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="col-md-2">
						<button type="button" id="cash_register_filter" class="btn btn-primary add-btn-modal">Филтрирай</button>
					</div>
				</div>
			@endif

			<table id="main_table" class="table">
				<thead>
					<tr>
						<th scope="col">Дата</th>
						<th scope="col">Приходи</th>
						<th scope="col">Разходи</th>
						<th scope="col">Салдо</th>
					</tr>
				</thead>
				<tbody>
					@foreach($register as $entry)
						@include('admin.cash_register.table')
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $register->links() }}
	</div>
</div>
@endsection