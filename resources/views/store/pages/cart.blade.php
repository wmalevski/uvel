@extends('store.layouts.app', ['bodyClass' => 'templateCart'])

@section('content')
<div id="content-wrapper-parent">
		<div id="content-wrapper">  
			<!-- Content -->
			<div id="content" class="clearfix">                
				<div id="breadcrumb" class="breadcrumb">
					<div itemprop="breadcrumb" class="container">
						<div class="row">
							<div class="col-md-24">
								<a href="./index.html" class="homepage-link" title="Back to the frontpage">Home</a>
								<span>/</span>
								<span class="page-title">Your Shopping Cart</span>
							</div>
						</div>
					</div>
				</div>        
                
				<section class="content">
					<div class="container">
						<div class="row">
							<div id="page-header" class="col-md-24">
								<h1 id="page-title">Кошница</h1>
							</div>
							<div id="col-main" class="col-md-24 cart-page content">
								<form action="{{ route('pay_order') }}" method="post" id="cartform" class="clearfix">
									<div class="row table-cart">
										<div class="wrap-table">
											<table class="cart-items haft-border">
											<colgroup>
											<col class="checkout-image">
											<col class="checkout-info">
											<col class="checkout-price">
											<col class="checkout-quantity">
											<col class="checkout-totals">
											</colgroup>
											<thead>
											<tr class="top-labels">
												<th>
													Продукт
												</th>
												<th>
													Цена
												</th>
												<th>
													Количество
												</th>
												<th>
													Тотал
												</th>
												<th>
													&nbsp;
												</th>
											</tr>
											</thead>
											<tbody>
                                            @foreach($items as $item)
                                                <tr class="item donec-condime-fermentum">
                                                    <td class="title text-left">
                                                        <ul class="list-inline">
                                                            <li class="image">
                                                            <a href="{{ route('single_product', ['product' => $item->attributes['product_id']])  }}">
                                                            {{-- <img src="{{ $item->attributes['photo'] }}" alt="{{ $item->attributes['name'] }}" width="150"> --}}
                                                            </a>
                                                            </li>
                                                            <li class="link">
                                                            <a href="{{ route('single_product', ['product' => $item->attributes['product_id']])  }}">
                                                            <span class="title-5">{{ $item->attributes['name'] }}</span>
                                                            </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="title-1">
														@if(count($items))
															{{ $item->price }} лв
														@endif
                                                    </td>
                                                    <td>
                                                        <input class="form-control input-1 replace" maxlength="5" size="5" id="updates_3947646083" name="updates[]" value="{{ $item->quantity }}">
                                                    </td>
                                                    <td class="total title-1">
															@if(count($items))
																{{ $item->price*$item->quantity }} лв
															@endif
                                                    </td>
                                                    <td class="action">
                                                        <button type="button" onclick="window.location='/cart/change?line=1&amp;quantity=0'"><i class="fa fa-times"></i>Изтрий</button>
                                                    </td>
                                                </tr>
                                            @endforeach
											
											</tbody>
											<tfoot>
											<tr class="bottom-summary">
												<td>
													&nbsp;
												</td>
												<td>
													&nbsp;
												</td>
												<td class="update-quantities">
													@if(count($items))
														<button type="submit" id="update-cart" class="btn btn-2" name="update">Обнови количество</button>
														
													@endif
												</td>
												<td class="subtotal title-1">
													{{ $subtotal }} лв
												</td>
												<td>
													&nbsp;
												</td>
											</tr>
											</tfoot>
											</table>
										</div>
									</div>
									<div class="row">
										<div id="checkout-addnote" class="col-md-24">
											<div class="wrapper-title">
												<span class="title-5">Допълнителна информация</span>
											</div>
											<textarea id="note" rows="8" class="form-control" name="information"></textarea>
										</div>

										@if ($message = Session::get('success'))
											<div class="w3-panel w3-green w3-display-container">
												<span onclick="this.parentElement.style.display='none'"
														class="w3-button w3-green w3-large w3-display-topright">&times;</span>
												<p>{!! $message !!}</p>
											</div>
											<?php Session::forget('success');?>
											@endif
										@if ($message = Session::get('error'))
											<div class="w3-panel w3-red w3-display-container">
												<span onclick="this.parentElement.style.display='none'"
														class="w3-button w3-red w3-large w3-display-topright">&times;</span>
												<p>{!! $message !!}</p>
											</div>
											<?php Session::forget('error');?>
										@endif
									</div>

									{{ csrf_field() }}
									<div class="form-row">
										<label>Начин на получаване</label>
										<hr>
										<div class="form-goroup">
											<input type="radio" class="cart-radio" name="shippingMethod" id="shipping_shop" data-method="store">
											<label for="shipping_shop"><i class="fas fa-store"></i> Вземи от магазин</label>
											<input type="radio" class="cart-radio" name="shippingMethod" id="shipping_address" data-method="ekont">
											<label for="shipping_address"><i class="fas fa-truck"></i> Доставка чрез Еконт</label>
										</div>
									</div>
									<div class="form-row shipping-method shipping_shop">
										<div class="form-group">
											<label>Моля изберете магазин:</label>
											<select name="store_id">
												<option>Избери магазин</option>
												@foreach($stores as $store)
													<option value="{{ $store->id }}">{{ $store->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-row shipping-method shipping_address">
										<label>Данни за доставка</label>
										<hr>
										<div class="form-group">
											<label>Град:</label>
											<input type="text" name="city" value="{{ Auth::user()->city }}">
										</div>
										<div class="form-group">
											<label>Улица:</label>
											<input type="text" name="street" value="{{ Auth::user()->street }}">
										</div>
										<div class="form-group">
											<label>Номер:</label>
											<input type="text" name="street_number" value="{{ Auth::user()->street_number }}">
										</div>
										<div class="form-group">
											<label>Пощенски код:</label>
											<input type="text" name="postcode" value="{{ Auth::user()->postcode }}">
										</div>
										<div class="form-group">
											<label>Телефон за връзка:</label>
											<input type="text" name="phone" value="{{ Auth::user()->phone }}">
										</div>
									</div>
									<div class="form-row payment-method">
										<label>Начин на плащане</label>
										<hr>
										<div class="form-goroup">
											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_borika" data-method="borika">
											<label for="payment_borika"><i class="far fa-credit-card"></i> С карта</label>
											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_paypal" data-method="paypal">
											<label for="payment_paypal"><i class="fab fa-paypal"></i> PayPal</label>
											<input type="radio" class="cart-radio" name="paymentMethod" id="payment_delivery" data-method="on_delivery">
											<label for="payment_delivery"><i class="far fa-money-bill-alt"></i> При получаване</label>
										</div>
									</div>

									{{ csrf_field() }}
									<input class="w3-input w3-border" name="amount" value="{{ $subtotal }}" type="hidden">      
									<input type="hidden" name="payment_method">
									<input type="hidden" name="shipping_method">
									<input class="w3-btn w3-blue" type="submit" value="Плати">
								</form>
								{{-- {{
									print_r(Session::get('cart_info'))
								}}
								{{session('cart_info.2.shipping_method')}} --}}
							</div>
						</div>
					</div>
				</section>        
			</div>
		</div>
	</div>
@endsection