<div class="quickview-modal-wrapper">
    <div class="modal-header">
        <i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="" data-dismiss="modal" aria-hidden="true" data-original-title="Close"></i>
    </div>
    <div class="modal-body">
        <div class="quick-shop-modal-bg" style="display: none;">
        </div>
        <div class="row">
            <div class="col-md-12 product-image">
                <div id="quick-shop-image" class="product-image-wrapper">

                    <a class="main-image"><img class="img-zoom img-responsive image-fly" src="@if($product->photos){{ asset("uploads/products/" . $product->photos->first()['photo']) }}@endif" alt=""/></a>

                    <div id="gallery_main_qs" class="product-image-thumb">
                        @if($product->photos)
                            @foreach($product->photos as $image)
                                <a class="image-thumb active" href="{{ asset("uploads/products/" . $image->photo) }}" data-image="{{ asset("uploads/products/" . $image->photo) }}" data-zoom-image="{{ asset("uploads/products/" . $image->photo) }}"><img src="{{ asset("uploads/products/" . $image->photo) }}" alt=""/></a>
                            @endforeach
                        @endif
                    </div>	
                </div>
            </div>
            <div class="col-md-12 product-information">
                <h1 id="quick-shop-title"><span> <a href="/products/curabitur-cursus-dignis">{{ $product->name }}</a></span></h1>
                <div id="quick-shop-infomation" class="description">
                    <div id="quick-shop-description" class="text-left">
                        <p>
                            No: {{ $product->code }} <br/>
                            {{ $product->weight }}гр. <br/>
                            {{-- Модел: {{ $product->model->name }} <br/>
                            Бижу: {{ $product->jewel->name }} <br/>
                            Размер: {{ $product->model->size }} --}}
                        </p>
                    </div>
                </div>
                <div id="quick-shop-container">
                    {{-- <div id="quick-shop-relative" class="relative text-left">
                        <ul class="list-unstyled">
                            <li class="control-group vendor">
                            <span class="control-label">Vendor :</span><a href="/collections/vendors?q=Vendor+1"> Vendor 1</a>
                            </li>
                            <li class="control-group type">
                            <span class="control-label">Type :</span><a href="/collections/types?q=Sweaters+Wear"> Sweaters Wear</a>
                            </li>
                        </ul>
                    </div> --}}
                    <form action="#" method="post" class="variants" id="quick-shop-product-actions" enctype="multipart/form-data">
                        <div id="quick-shop-price-container" class="detail-price">
                            <span class="price_sale">{{ $product->price }}лв.</span><span class="dash"></span>
                            {{-- <del class="price_compare">$300.00</del> --}}
                        </div>
                        <div class="others-bottom">
                            <input id="quick-shop-add" class="btn small add_to_cart" type="submit" name="add" value="Добави в количката" data-url="{{ route('CartAddItem', ['item' => $product->barcode, 'quantity' => 1]) }}" style="opacity: 1;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>