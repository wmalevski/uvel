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

                    <a class="main-image"><img class="img-zoom img-responsive image-fly" src="@if($model->photos){{ asset("uploads/models/" . $model->photos->first()['photo']) }}@endif" alt=""/></a>

                    <div id="gallery_main_qs" class="product-image-thumb">
                        @if($model->photos)
                            @foreach($model->photos as $image)
                                <a class="image-thumb active" href="{{ asset("uploads/models/" . $image->photo) }}" data-image="{{ asset("uploads/models/" . $image->photo) }}" data-zoom-image="{{ asset("uploads/models/" . $image->photo) }}"><img src="{{ asset("uploads/models/" . $image->photo) }}" alt=""/></a>
                            @endforeach
                        @endif
                    </div>	
                </div>
            </div>
            <div class="col-md-12 product-information">
                <h1 id="quick-shop-title"><span> <a href="/products/curabitur-cursus-dignis">{{ $model->name }}</a></span></h1>
                <div id="quick-shop-infomation" class="description">
                    <div id="quick-shop-description" class="text-left">
                        <p>
                            Модел: {{ $model->name }} <br/>
                            Бижу: {{ $model->jewel->name }} <br/>
                            Размер: {{ $model->size }}
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
                            <span class="price_sale">{{ $model->price }}лв.</span><span class="dash"></span>
                            {{-- <del class="price_compare">$300.00</del> --}}
                        </div>
                        <div class="others-bottom">
                            <input id="quick-shop-add" class="btn small add-to-cart" type="submit" name="add" value="Добави в количката" style="opacity: 1;">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>