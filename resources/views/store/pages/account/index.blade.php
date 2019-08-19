@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div id="content-wrapper-parent" class="page-store-account">
	<div id="content-wrapper">
		<!-- Content -->
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('user_account') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header" class="col-md-24">
							<h1 id="page-title">Моят профил</h1>
						</div>
						<div class="col-sm-6 col-md-6 sidebar">
							<div class="group_sidebar">
								<div class="row sb-wrapper unpadding-top">
									<h6 class="sb-title">Информация</h6>
									<ul id="customer_detail" class="list-unstyled sb-content">
										<li>
											<address class="clearfix">
												<div class="info">
													<i class="fa fa-user"></i>
													<span class="address-group">
														<span class="author">{{Auth::user()->name}}</span>
														<span class="email">{{Auth::user()->email}}</span>
													</span>
												</div>
												<div class="address">
													<span class="address-group">
														<span class="address1">
															{{Auth::user()->street}} {{Auth::user()->street_number}}<br>{{Auth::user()->country}}
															<span class="phone-number">{{Auth::user()->phone}}</span>
														</span>
													</span>
												</div>
											</address>
										</li>
										<li>
											<a class="btn btn-1" href="{{route('wishlist')}}">Списък с желани</a>
										</li>
										<li>
											<a class="btn btn-1" href="{{route('model_orders')}}">Поръчки</a>
										</li>
										<li>
											<a class="btn btn-1" href="{{route('user_settings')}}">Настройки</a>
										</li>
										<hr class="divider">
										<li>
											<a class="btn btn-1" href="{{route('logout')}}">Изход</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div id="col-main" class="account-page col-sm-18 col-md-18 clearfix">
							<div id="customer_orders">
								<h6 class="sb-title">История на покупки</h6>
								<div class="row wrap-table">
									<table class="table-hover">
										<thead>
											<tr>
												<th>Метод на доставка</th>
												<th>Метод на плащане</th>
												<th>Цена</th>
												<th>Дата</th>
												<th>Статус</th>
											</tr>
										</thead>

										<tbody>
											@foreach($sellings as $selling)
											<tr data-id="{{ $selling->id }}">
												<td>
													@if($selling->shipping_method == 'ekont')
													Еконт
													@elseif($selling->shipping_method == 'store')
													Взимане от магазин
													@endif
												</td>
												<td>
													@if($selling->payment_method == 'on_delivery')
													Наложен платеж
													@elseif($selling->payment_method == 'paypal')
													Paypal
													@endif
												</td>
												<td>{{ $selling->price }}лв.</td>
												<td>{{ $selling->created_at }}</td>
												<td>
													@if($selling->status == 'waiting_user')
													Очаква изпращане/вземане
													@elseif($selling->status == 'done')
													Приключена
													@endif
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection
