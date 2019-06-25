@extends('store.layouts.app', ['bodyClass' => 'templateCart'])

@section('content')
	<div id="content-wrapper-parent">
		<div id="content-wrapper">
			<div id="content" class="clearfix">
				<div id="breadcrumb" class="breadcrumb">
					<div itemprop="breadcrumb" class="container">
						<div class="row">
							<div class="col-md-24">
								{{ Breadcrumbs::render('cart') }}
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container">
						<div class="row">
							<div id="page-header" class="col-md-24">
								<h1 id="page-title">Количка</h1>
							</div>
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
												<tbody>
												@foreach($items as $item)
													<tr class="item">
														<td class="title text-left">
															<ul class="list-inline">
																<li class="image">

																	<a class="cart-item-image img-fill-container"
																	   href="{{ route('single_product', ['product' => $item->attributes->product_id])  }}">
																		@if(App\Product::find($item->attributes->product_id) && count(App\Product::find($item->attributes->product_id)->photos))
																			<img src="{{ asset("uploads/products/" . App\Product::find($item->attributes->product_id)->photos->first()->photo) }}"
																				 alt="{{ $item->attributes->name }}"
																				 width="150">
																		@endif
																		@if(App\Gallery::where('product_other_id', $item->attributes->product_id)->get())
																			<img src="{{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $item->attributes->product_id)->first()->photo) }}"
																				 alt="{{ $item->attributes->name }}"
																				 width="150">
																		@endif
																	</a>

																</li>
																<li class="link">
																	<a href="{{ route('single_product', ['product' => $item->attributes->product_id])  }}">
																		<span class="title-5">{{ $item->attributes->name }}</span>
																	</a>
																</li>
															</ul>
														</td>

														<td class="price-item title-1">
															<p>
																@if(count($items))
																	{{ $item->price }} лв.
																@endif
															</p>
														</td>

														<td>
															<p>
																@if($item->attributes->type != 'product')
																	<input class="form-control input-1 replace update-cart-quantity"
																		   maxlength="5" size="5"
																		   id="updates_3947646083"
																		   data-url="{{ route('CartUpdateItem', ['item' => $item->id, 'quantity' => '']) }}/"
																		   name="updates[]" type="number"
																		   value="{{ $item->quantity }}">
																@else
																	1
																@endif
															</p>
														</td>

														<td class="total title-1">
															<p>
																@if(count($items))
																	{{ $item->price*$item->quantity }} лв.
																@endif
															</p>
														</td>

														<td class="action">
															<button type="button" class="remove-from-cart"
																	data-url="{{ route('CartRemoveItem', ['item' => $item->id]) }}">
																<i class="fa fa-times"></i>
																Изтрий
															</button>
														</td>

													</tr>
												@endforeach

												</tbody>
												<tfoot>
												<tr class="bottom-summary">
													<th>&nbsp;</th>
													<td class="subtotal title-1">
														{{ $subtotal }} лв.
													</td>
													<td>
														@if(count($items))
															<button type="submit" id="update-cart" class="btn btn-2"
																	name="update">Обнови количество
															</button>
														@endif
													</td>
													<td class="subtotal title-1">
														{{ $total }} лв.
													</td>
													<td>
														&nbsp;
													</td>
												</tr>
												</tfoot>
											</table>
										</div>
									</div>
									@Auth
										<div class="row form-row">
											<label>Допълнителна информация</label>
											<hr>
											<div id="checkout-addnote" class="col-md-24">
												<textarea id="note" rows="8" class="form-control"
														  name="information"></textarea>
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
										<div class="form-row row">
											<label>Отстъпки</label>
											<hr>
											<div class="discount-container">
												@foreach($conditions as $condition)
													<div class="col-xs-24">
														<span class="discount discount-label">{{ $condition->getValue() }}</span>
														<span data-url="/ajax/removeDiscount/{{ $condition->getName() }}"
															  class="discount discount-remove">
													<i class="fas fa-times"></i>
												</span>
													</div>
												@endforeach
											</div>
											<div class="form-group col-xs-24 col-sm-12">
												<label>Въведете номер на карта за отстъпка:</label>
												<div class="input-group">
													<input type="number" id="discountCard" class="form-control"
														   name="discount" placeholder="Баркод">
													<span class="input-group-addon">
													<i class="fas fa-barcode"></i>
												</span>
												</div>
											</div>
											<div class="col-xs-24">
												<div class="cart-btn cart-applyDiscount"
													 data-url="/online/cart/addDiscount/">
													<span class="btn-text">Приложи отстъпка</span>
												</div>
											</div>
										</div>
										<div class="form-row row">
											<label>Начин на получаване</label>
											<hr>
											<div class="form-goroup col-xs-24">
												<input type="radio" class="cart-radio" name="shippingMethod"
													   id="shipping_shop" data-method="store">
												<label for="shipping_shop"><i class="fas fa-store"></i> Вземи от магазин</label>
												<input type="radio" class="cart-radio" name="shippingMethod"
													   id="shipping_address" data-method="ekont">
												<label for="shipping_address"><i class="fas fa-truck"></i> Доставка чрез
													Еконт</label>
											</div>
										</div>
										<div class="form-row row shipping-method shipping_shop">
											<div class="form-group col-xs-24">
												<label>Моля изберете магазин:</label>
												<select name="store_id">
													<option>Избери магазин</option>
													@foreach($stores as $store)
														<option value="{{ $store->id }}">{{ $store->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="form-row row shipping-method shipping_address">
											<label>Данни за доставка</label>
											<hr>
											<div class="form-group col-xs-24">
												<label>Град:</label>
												<input type="text" name="city"
													   value="@if (Auth::check()){{  Auth::user()->city }} @endif">
											</div>
											<div class="form-group col-xs-24">
												<label>Улица:</label>
												<input type="text" name="street"
													   value="@if (Auth::check()){{ Auth::user()->street }} @endif">
											</div>
											<div class="form-group col-xs-24">
												<label>Номер:</label>
												<input type="text" name="street_number"
													   value="@if (Auth::check()){{ Auth::user()->street_number }} @endif">
											</div>
											<div class="form-group col-xs-24">
												<label>Пощенски код:</label>
												<input type="text" name="postcode"
													   value="@if (Auth::check()){{ Auth::user()->postcode }} @endif">
											</div>
											<div class="form-group col-xs-24">
												<label>Телефон за връзка:</label>
												<input type="text" name="phone"
													   value="@if (Auth::check()){{ Auth::user()->phone }} @endif">
											</div>
										</div>
										<div class="form-row row payment-method">
											<label>Начин на плащане</label>
											<hr>
											<div class="form-goroup col-xs-24">
												<input type="radio" class="cart-radio" name="paymentMethod"
													   id="payment_borika" data-method="borika">
												<label for="payment_borika"><i class="far fa-credit-card"></i> С
													карта</label>
												<input type="radio" class="cart-radio" name="paymentMethod"
													   id="payment_paypal" data-method="paypal">
												<label for="payment_paypal"><i class="fab fa-paypal"></i> PayPal</label>
												<input type="radio" class="cart-radio" name="paymentMethod"
													   id="payment_delivery" data-method="on_delivery">
												<label for="payment_delivery"><i class="far fa-money-bill-alt"></i> При
													получаване</label>
											</div>
										</div>

										{{ csrf_field() }}
										<input class="w3-input w3-border" name="amount" value="{{ $subtotal }}"
											   type="hidden">
										<input type="hidden" name="payment_method">
										<input type="hidden" name="shipping_method">
										<input class="w3-btn w3-blue" type="submit" value="Плати">
									@else
										<div class="row form-row">
											<label>Влезте в профила си, за да продължите.</label>
										</div>
									@endauth
								</form>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
@endsection
