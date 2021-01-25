@extends('store.layouts.app', ['bodyClass' => 'templateCart'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">{{ Breadcrumbs::render('cart') }}</div>
					</div>
				</div>
			</div>

			@if(session('success'))
			<div class="info-message success" style="top: 75px; overflow: hidden; display: block;">{{ session('success') }}</div>
			@elseif(session('error'))
			<div class="info-message error" style="top: 75px; overflow: hidden; display: block;">{{ session('error') }}</div>
			@endif

			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header" class="col-md-24"><h1 id="page-title">Количка</h1></div>
						<div id="col-main" class="col-md-24 cart-page content">
							<form action="{{ route('pay_order') }}" method="post" id="cartform" class="clearfix">
								<div class="row table-cart">
									<div class="wrap-table">
										<table class="cart-items haft-border">
											<thead>
												<tr class="top-labels">
													<th><p>Продукт</p></th>
													<th>Цена</th>
													<th>Количество</th>
													<th>Тотал</th>
													<th>&nbsp;</th>
												</tr>
											</thead>
											<tbody>{!! $table_items !!}</tbody>
											<tfoot>
												<tr class="bottom-summary">
													<th>&nbsp;</th>
													<td class="subtotal title-1">{{ $subtotal }} лв.</td>
													<td>
													@if(count($items))
														<button type="submit" id="update-cart" class="btn btn-2" name="update">Обнови количество</button>
													@endif
													</td>
													<td class="subtotal title-1">{{ $total }} лв.</td>
													<td>&nbsp;</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
								@if (!empty($items))
								@Auth
									<div class="row form-row">
										<label>Допълнителна информация</label>
										<hr>
										<div id="checkout-addnote" class="col-md-24">
											<textarea id="note" rows="8" class="form-control" name="information"></textarea>
										</div>
									@if ($message = Session::get('success'))
										<div class="w3-panel w3-green w3-display-container">
											<span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-large w3-display-topright">&times;</span>
											<p>{!! $message !!}</p>
										</div>
										<?php Session::forget('success');?>
									@elseif ($message = Session::get('error'))
										<div class="w3-panel w3-red w3-display-container">
											<span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
											<p>{!! $message !!}</p>
										</div>
										<?php Session::forget('error');?>
									@endif
									</div>

									{{ csrf_field() }}
									<div class="form-row row">
										<label>Отстъпки</label>
										<hr>
										<div class="discount-container">
										@foreach($conditions as $condition)
											<div class="col-xs-24">
												<span class="discount discount-label">{{ $condition->getValue() }}</span>
												<span data-url="/ajax/removeDiscount/{{ $condition->getName() }}" class="discount discount-remove"><i class="fas fa-times"></i></span>
											</div>
										@endforeach
										</div>
										<div class="form-group col-xs-24 col-sm-12">
											<label>Въведете номер на карта за отстъпка:</label>
											<div class="input-group">
												<input type="number" id="discountCard" class="form-control" name="discount" placeholder="Баркод">
												<span class="input-group-addon"><i class="fas fa-barcode"></i></span>
											</div>
										</div>
										<div class="col-xs-24">
											<div class="cart-btn cart-applyDiscount" data-url="/online/cart/addDiscount/">
												<span class="btn-text">Приложи отстъпка</span>
											</div>
										</div>
									</div>
									<div class="form-row row">
										<label>Начин на получаване</label>
										<hr>
										<div class="form-goroup col-xs-24">
											<input type="radio" class="cart-radio" name="shippingMethod" id="shipping_shop" data-method="store" />
											<label for="shipping_shop"><i class="fas fa-store"></i> Вземи от магазин</label>
											<input type="radio" class="cart-radio" name="shippingMethod" id="shipping_address" data-method="office_address" />
											<label for="shipping_address"><i class="fas fa-truck"></i>Получаване от офис на куриер</label>
											<input type="radio" class="cart-radio" name="shippingMethod" id="shipping_home_address" data-method="home_address" />
											<label for="shipping_home_address"><i class="fas fa-truck"></i>Получаване на адрес</label>
										</div>
									</div>
									<div class="form-row row shipping-method shipping_shop">
										<div class="form-group col-xs-24">
											<label>Моля изберете магазин:</label>
											<select name="store_id">
											@foreach($stores as $store1 => $store)
												<option value="{{ $store->id }}" @if($store1 == 0) selected="selected" @endif>{{ $store->name }}</option>
											@endforeach
											</select>
										</div>
									</div>
									<div class="form-row row shipping-method shipping_address">
										<label>Данни за доставка</label>
										<hr>
										<div class="form-group col-xs-24">
											<label>Град:</label>
											<input type="text" name="city" />
										</div>
										<div class="form-group col-xs-24">
											<label>Улица:</label>
											<input type="text" name="street" />
										</div>
										<div class="form-group col-xs-24">
											<label>Номер:</label>
											<input type="text" name="street_number" />
										</div>
										<div class="form-group col-xs-24">
											<label>Пощенски код:</label>
											<input type="text" name="postcode" />
										</div>
										<div class="form-group col-xs-24">
											<label>Телефон за връзка:</label>
											<input type="text" name="phone" />
										</div>
									</div>
									<div class="form-row row shipping-method shipping_home_address">
										<label>Данни за доставка</label>
										<hr>
										<div class="form-group col-xs-24">
											<label>Град:</label>
											<input type="text" name="city" value="@if (Auth::check()){{  Auth::user()->city }} @endif" />
										</div>
										<div class="form-group col-xs-24">
											<label>Улица:</label>
											<input type="text" name="street" value="@if (Auth::check()){{ Auth::user()->street }} @endif" />
										</div>
										<div class="form-group col-xs-24">
											<label>Номер:</label>
											<input type="text" name="street_number" value="@if (Auth::check()){{ Auth::user()->street_number }} @endif" />
										</div>
										<div class="form-group col-xs-24">
											<label>Пощенски код:</label>
											<input type="text" name="postcode" value="@if (Auth::check()){{ Auth::user()->postcode }} @endif" />
										</div>
										<div class="form-group col-xs-24">
											<label>Телефон за връзка:</label>
											<input type="text" name="phone" value="@if (Auth::check()){{ Auth::user()->phone }} @endif" />
										</div>
									</div>
									<div class="form-row row payment-method">
										<label>Начин на плащане</label>
										<hr>
										<div class="form-goroup col-xs-24">
											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_borika" data-method="borika" />
											<label for="payment_borika"><i class="far fa-credit-card"></i> С карта</label>

											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_paypal" data-method="paypal" />
											<label for="payment_paypal"><i class="fab fa-paypal"></i> PayPal</label>

											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_delivery" data-method="on_delivery" />
											<label for="payment_delivery"><i class="far fa-money-bill-alt"></i> При получаване</label>
										</div>
									</div>

									{{ csrf_field() }}
									<input class="w3-input w3-border" name="amount" value="{{ $subtotal }}" type="hidden" />
									<input type="hidden" name="payment_method" />
									<input type="hidden" name="shipping_method" />
									<input class="w3-btn w3-blue" type="submit" value="Плати" />
									@else
									<div class="row form-row">
										<a href="/online/login">Влезте в профила си, за да продължите.</a>
									</div>
								@endauth
								@endif
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<style type="text/css">
tr.modelProduct, tr.modelProduct>td{
	border-bottom: 1px solid transparent !important;
}
td.modelSize div{
    display: flex;
    justify-content: center;
    align-items: flex-start;
}
td.modelSize div textarea{
	height: 40px;
	min-height: 40px;
	max-height: 40px;
	flex: 1 1 auto;
	resize: none;
	line-height: 30px;
	padding: 2px 5px;
}
td.modelSize div label{
	margin-right: 10px;
	line-height: 40px;
}
</style>
@endsection