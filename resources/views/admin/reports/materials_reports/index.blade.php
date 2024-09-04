@extends('admin.layout')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="bgc-white bd bdrs-3 p-20 mB-20" style="position:relative;">
			<h4 class="c-grey-900 mB-20">Материали</h4>
			<p style='float:left;width:50%;'>Преглед на наличните материали.</p>
			<div style="position:absolute;top:20px;right:10px" class='form-row col-md-6'>
				@if(in_array(Auth::user()->role, array('admin', 'storehouse')))
				<div class='form-group col-md-7'>
					<select id="reportsStoreSelector" class="form-control" >
						<option value="all">Всички обекти</option>
						@foreach($stores as $store)
						<option value="{{$store->id}}">{{$store->name}}, {{$store->location}}</option>
						@endforeach
					</select>
				</div>
				@endif
				<div class='form-group col-md-3'>
					<a href="{{route('printMaterialsReport', 'all')}}" class="add-btn btn btn-primary" id="reportPrintButton">Принтирай дневна справка</a>
				</div>
			</div>
			<br style="clear:both" />
			<table id="main_table" class="table">
				<thead>
					<tr>
						<th scope="col">Материал</th>
						@foreach($stores as $store)
						<th scope="col">{{ $store->name }} - {{ $store->location }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody>
					@foreach($materials_quantities as $materials_quantity)
					@include('admin.reports.materials_reports.table')
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $materials_quantities->links() }}
	</div>
</div>
@endsection
@section('footer-scripts')
<style type="text/css">
	.select2-container--default .select2-selection--single .select2-selection__rendered{line-height:34px;}
	.select2-container--default .select2-selection--single .select2-selection__arrow{height:34px;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(document.body).on('change', 'select#reportsStoreSelector', function(){
			var storeVal = $('select#reportsStoreSelector').val();
			var reportPrintButton = $('a#reportPrintButton');
			var url = reportPrintButton.attr('href');
			var newURL = url.substr(0, url.lastIndexOf("/")) + "/" + storeVal;
			reportPrintButton.attr('href', newURL);
		});
	});
</script>
@endsection