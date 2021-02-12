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
											<input type="text" name="courier_city"
											oninvalid="this.setCustomValidity('Моля въведете Град')"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Улица:</label>
											<input type="text" name="courier_street"
											oninvalid="this.setCustomValidity('Моля въведете Име на Улица')"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Номер:</label>
											<input type="text" name="courier_street_number"
											oninvalid="this.setCustomValidity('Моля въведете Номер на Улица')"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Пощенски код:</label>
											<input type="text" name="courier_postcode"
											oninvalid="this.setCustomValidity('Моля въведете Пощенски Код')"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Телефон за връзка:</label>
											<input type="text" name="courier_phone"
											oninvalid="this.setCustomValidity('Моля въведете Телефон за Връзка')"
											oninput="setCustomValidity('')"/>
										</div>
									</div>
									<div class="form-row row shipping-method shipping_home_address">
										<label>Данни за доставка</label>
										<hr>
										<div class="form-group col-xs-24">
											<label>Град:</label>
											<input type="text" name="city" value="{{Auth::user()->city}}"
											oninvalid="this.setCustomValidity('Моля въведете Град за доставка');this.scrollIntoView({block: 'center'})"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Улица:</label>
											<input type="text" name="street" value="{{Auth::user()->street}}"
											oninvalid="this.setCustomValidity('Моля въведете Име на Улица');this.scrollIntoView({block: 'center'})"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Номер:</label>
											<input type="text" name="street_number" value="{{Auth::user()->street_number}}"
											oninvalid="this.setCustomValidity('Моля въведете Номер на Улица');this.scrollIntoView({block: 'center'})"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Пощенски код:</label>
											<input type="text" name="postcode" value="{{Auth::user()->postcode}}"
											oninvalid="this.setCustomValidity('Моля въведете Пощенски Код');this.scrollIntoView({block: 'center'})"
											oninput="setCustomValidity('')"/>
										</div>
										<div class="form-group col-xs-24">
											<label>Телефон за връзка:</label>
											<input type="phone" name="phone" value="{{Auth::user()->phone}}"
											oninvalid="this.setCustomValidity('Моля въведете Телефон за Връзка');this.scrollIntoView({block: 'center'})"
											oninput="setCustomValidity('')" />
										</div>
									</div>
									<div class="form-row row payment-method">
										<label>Начин на плащане</label>
										<hr>
										<div class="form-goroup col-xs-24">
											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_borika" data-method="borika" />
											<label for="payment_borika"><i class="far fa-credit-card"></i> С карта</label>

											<!-- <input type="radio" class="cart-radio" name="paymentMethod" id="payment_paypal" data-method="paypal" />
											<label for="payment_paypal"><i class="fab fa-paypal"></i> PayPal</label> -->

											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_delivery" data-method="on_delivery" />
											<label for="payment_delivery"><i class="far fa-money-bill-alt"></i> При получаване</label>
										</div>
									</div>

									{{ csrf_field() }}
									<input class="w3-input w3-border" name="amount" value="{{ $subtotal }}" type="hidden" />
									<input type="hidden" name="payment_method" />
									<input type="hidden" name="shipping_method" />
									<input class="w3-btn w3-blue" type="submit" value="Поръчай" />
									@else
									<div>
										<a class="pleaseLogin" href="/online/login">Моля влезте в профила си, за да продължите</a>
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
a.pleaseLogin{
    font-size: 1.2em;
    width: 500px;
    margin: 0 calc(50% - 250px);
    text-align: center;
    display: inline-block;
    padding: 5px 0;
    background: #b5930e;
    color: white;
    text-shadow: 0 1px black;
    box-shadow: 0px 5px 10px -3px black;
    position: relative;
    top:0;
    transition: all 200ms ease-in-out;
}
a.pleaseLogin:active, a.pleaseLogin:hover{background: #caa412;}
a.pleaseLogin:active{top:3px;box-shadow: 0px 0 5px -4px black;}
</style>
<script type="text/javascript">
$(document).ready(function(){

	$("form#cartform").on("submit",function(e){
		try{
			// Validate Shipping method
			let shipMet=$('input[name="shippingMethod"]:checked');
			if(shipMet.length==0){
				var tOffset=$('input[name="shippingMethod"]').offset();
				$('html').animate({ scrollTop: tOffset.top - 100 },400,function(){
					alert("Моля изберете Начин на Получаване");
				});
				throw false;
			}

			// Validate Payment method
			let payMet = $('input[name="paymentMethod"]:checked');
			if(payMet.length==0){
				var tOffset=$('input[name="paymentMethod"]').offset();
				$('html').animate({ scrollTop: tOffset.top - 100 },400,function(){
					alert("Моля изберете Начин на Плащане");
				});
				throw false;
			}

			// Remove the non-selected delivery form fields to bypass false-positive "required" fails
			$('div.shipping-method').each(function(){
				if($(this).is(":hidden")){$(this).remove();}
			});
		}
		catch(err){
			console.log(err);
			e.preventDefault();
		}

	});
});
</script>
@endsection