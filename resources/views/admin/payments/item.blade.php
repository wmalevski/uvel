<tr data-id="{{$payment->id}}">
	<td>{{$payment->user->getStore()->name}}, {{$payment->user->getStore()->location}}</td>
	<td>{{$payment->created_at->format('H:i d/m/Y')}}</td>
	<td>{{$payment->price}}</td>
	<td>@switch($payment->method)
		@case('cash') Кеш @break;
		@case('post') ПОС Терминал @break;
	@endswitch</td>
	<td>@if($payment->receipt == 'yes') 1 @else 0 @endif</td>
	<td>{{$payment->user->email}}</td>
	<td>
	@if(count($payment->discounts))
		@foreach($payment->discounts as $discount)
		@if($discount->discount_code_id) Приложена Отстъпка: {{$discount->discount_code_id}} @endif
		@endforeach
		<br/>
	@endif

	@if(isset($payment->sellings))
	@foreach($payment->sellings as $key => $selling)
		<br/>
		@if($selling->product_id && $selling->product_id !== 'exchange_material')
			<?php $product = App\Product::where('id', $selling->product_id)->first(); ?>
			@if($product && $product->photos && $product->photos->first())
				<img class="admin-product-image" src="{{ asset("uploads/products/" . $product->photos->first()['photo']) }}">
			@endif
			{{App\Model::where('id', $product->model_id)->first()->name}} - №: {{$selling->product_id}}
		@elseif($selling->repair_id)
			Ремонт - {{App\Repair::where('id', $selling->repair_id)->first()->customer_name}} - №: {{$selling->repair_id}}
		@elseif($selling->product_other_id)
			<?php $productOther = App\ProductOther::where('id', $selling->product_other_id)->first(); ?>
			@if($productOther && $productOther->photos && $productOther->photos->first())
				<img class="admin-product-image" src="{{ asset("uploads/products_others/" . $productOther->photos->first()['photo']) }}" />
				{{$productOther->name}} - №: {{$selling->product_other_id}}
			@endif
		@elseif($selling->product_id && $selling->product_id == 'exchange_material')
			<?php $exchangeMaterial = App\ExchangeMaterial::where('payment_id', $payment->id)->first(); ?>
			Изкупуване на материали - №: {{$exchangeMaterial->id}}
		@elseif($selling->order_id)
			<?php $customer = App\Order::where('id', $selling->order_id)->first(); ?>
			Поръчка - №: {{$selling->order_id}} @if($customer) - {{$customer->customer_name}} @endif
		@endif
	@endforeach
	@endif

	@if(isset($payment->info))
		<br/>Допълнителна информация: {{ $payment->info }}
	@endif
	</td>
	<td>
		@if($payment->sellings->isEmpty() === true && $payment->exchange_materials->isEmpty() === false )
			Разсписка (Обмяна): <a data-print-label="true" target="_blank" href="/ajax/generate/exchangeacquittance/{{$payment->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
		@elseif($payment->sellings->isEmpty() === false)
			@foreach($payment->sellings as $selling)
				@if(isset($selling->product_id) && $selling->product_id !=='exchange_material')
					<?php $product = App\Product::where('id', $selling->product_id)->first(); ?>
					@if($product)
						Сертификат ({{$product->name}} - №: {{$selling->product_id}}):
						<a data-print-label="true" target="_blank" href="{{route('selling_certificate', array('id'=>$selling->product_id, 'orderId'=>null))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
						Разсписка ({{$product->name}} - №: {{$selling->product_id}}):
						<a data-print-label="true" target="_blank" href="{{route('selling_receipt', array('id'=>$selling->product_id, 'type' => 'product', 'orderId' => null))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
					@endif
				@elseif(isset($selling->product_other_id))
					<?php $productOther = App\ProductOther::where('id', $selling->product_other_id)->first(); ?>
					@if($productOther)
						Разсписка ({{$productOther->name}} - №: {{$selling->product_other_id}}):
						<a data-print-label="true" target="_blank" href="{{route('selling_receipt', array('id'=>$selling->product_other_id, 'type' => 'box', 'orderId' => null))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
					@endif
				@elseif(isset($selling->model_id))
					<?php $model = App\Model::where('id', $selling->model_id)->first(); ?>
					@if($model)
						Разсписка ({{$model->name}} - №: {{$selling->model_id}}):
						<a data-print-label="true" target="_blank" href="{{route('selling_receipt', array('id'=>$selling->model_id, 'type' => 'box', 'orderId' => null))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
					@endif
				@elseif(isset($selling->repair_id))
					Разсписка (Ремонт - №: {{$selling->repair_id}}):
					<a data-print-label="true" target="_blank" href="{{route('repair_receipt', array('id'=>$selling->repair_id))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
				@elseif(isset($selling->product_id) && $selling->product_id =='exchange_material')
					Разсписка №: {{$exchangeMaterial->id}}:
					<a data-print-label="true" target="_blank" href="{{route('selling_receipt', array('id'=>$payment->id,'type'=>'order','orderId'=>$payment->id))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a><br>
				@elseif(isset($selling->order_id))
					<b>Разсписка за цялата поръчка (№: {{$selling->order_id}}): <a data-print-label="true" target="_blank" href="{{route('selling_receipt',array('id'=>$selling->order_id, 'type'=>'order', 'orderId'=>$selling->order_id ))}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a></b><br>
				@endif
			@endforeach
		@endif
	</td>
</tr>