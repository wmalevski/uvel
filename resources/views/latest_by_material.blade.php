@foreach($materials as $material)
    @php
        $materialsOnline = $material->productsOnline->take(12);
    @endphp
    <div class="home-feature">
        <div class="container">
            <div class="group_featured_products row">
                <div class="col-md-24">
                    <div class="home_fp">
                        <h6 class="general-title">Последни от {{$material->name}}</h6>
                        <div class="home_fp_wrapper">
                            <div class="home_fp2">
                                @foreach($materialsOnline as $product)
                                    @if (strtolower($product->store_info->name)!=='склад')
                                        @php
                                            $imageSrc = asset('store/images/demo_375x375.png');
                                            if(count($product->photos) && isset($product->photos->first()['photo']) ){
                                                $imageSrc = asset("uploads/products/" . $product->photos->first()['photo']);
                                            }
                                            elseif(count($product->model->photos) && isset($product->model->photos->first()['photo'])){
                                                $imageSrc = asset("uploads/models/" . $product->model->photos->first()['photo']);
                                            }
                                        @endphp
                                        <li class="element no_full_width" data-alpha="{{$product->name}}" data-price="{{$product->price}}" data-id="{{$product->id}}">
                                            <ul class="row-container list-unstyled clearfix">
                                                <li class="row-left">
                                                    <a href="{{route('single_product', array('product' => $product->id))}}" class="container_item">
                                                        <img  class="img-fill" class="img-zoom img-responsive image-fly" alt="{{$product->name}}" src="{{$imageSrc}}" >
                                                    </a>
                                                    <div class="hbw">
                                                        <span class="hoverBorderWrapper"></span>
                                                    </div>
                                                </li>
                                                <li class="row-right parent-fly animMix">
                                                    <div class="product-content-left">
                                                        <a class="title-5" href="{{route('single_product', array('product' => $product->id))}}">No: {{$product->id}}</a><br>Модел: {{$product->model->name}}<br>{{$product->material->name}} - {{$product->material->code}} - {{$product->material->color}}<br>{{$product->weight}} гр.<br>Налично в: {{$product->store_info->name}}
                                                        <span class="spr-badge" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating">
                                                                {!!$product->listProductAvgRatingStars($product)!!}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="product-content-right">
                                                        <div class="product-price">
                                                            <span class="price">{{number_format($product->price)}} лв.</span>
                                                        </div>
                                                    </div>
                                                    <div class="hover-appear">
                                                        <a href="{{route('single_product', array('product' => $product->id))}}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
                                                            <i class="fa fa-lg fa-eye"></i>
                                                            <span class="list-mode">Преглед</span>
                                                        </a>
                                                        @if(Auth::check())
                                                            <button class="wish-list" title="Добави в желани" data-url="{{route('wishlists_store',array('type'=>'product','item'=>$product->id))}}"><i class="fa fa-lg fa-heart"></i><span class="list-mode">Добави в желани</span></button>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
