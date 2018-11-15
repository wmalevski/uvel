@extends('store.layouts.app', ['bodyClass' => 'templateWishlist'])

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
                            <span class="page-title">Wishlist Page</span>
                        </div>
                    </div>
                </div>
            </div>        
            
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Запазени продукти</h1>
                        </div>
                        <div id="col-main" class="col-md-24 clearfix">
                            <div class="page page-wishlist">
                                <div class="table-cart">
                                    <div class="wrap-table">
                                        <table class="cart-items haft-border">
                                            <thead>
                                                <tr class="top-labels">
                                                    <th class="text-left">Продукти</th>
                                                    <th>Цена</th>
                                                    <th>Премахни</th>
                                                    <th>Добави в количка</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($wishList as $wishListItem)
                                                    <tr class="item wishlist-item">
                                                        <td class="title text-left">
                                                            <ul class="list-inline">
                                                                <li class="image">
                                                                    <a class="image text-left" href="{{$wishListItem->checkWishListItemType($wishListItem)['url']}}">
                                                                        @if ($wishListItem->product_id)
                                                                            <img src="@if($wishListItem->product->photos) {{ asset("uploads/models/" . $wishListItem->product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $wishListItem->product->name }}">
                                                                        @elseif ($wishListItem->model_id)
                                                                            <img src="@if($wishListItem->model->photos) {{ asset("uploads/models/" . $wishListItem->model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $wishListItem->model->name }}">
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                <li class="link">
                                                                    <a class="title text-left" href="{{$wishListItem->checkWishListItemType($wishListItem)['url']}}">
                                                                        {{$wishListItem->checkWishListItemType($wishListItem)['item']->name}}
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td class="title-1">
                                                            {{$wishListItem->checkWishListItemType($wishListItem)['item']->price}} лв.
                                                        </td>
                                                        <td class="action">
                                                            <form method="post" action="/contact" class="contact-form" accept-charset="UTF-8">
                                                                <input type="hidden" value="customer" name="form_type"><input type="hidden" name="utf8" value="✓">
                                                                <input type="hidden" name="contact[email]" value="abc@gmail.com">
                                                                <input type="hidden" name="contact[tags]" value="x1293232771">
                                                                <button type="submit"><i class="fa fa-times"></i></button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="./cart.html" method="post">
                                                                <input type="hidden" name="id" value="3947639491">
                                                                <a class="btn" href="./products.html">ADD TO CART</a>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a class="control-label" href="mailto:?subject=http://designshopify.com">Share my wish list via email</a>
                                </div>
                            </div>
                            <!-- /#col-main -->
                        </div>
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection