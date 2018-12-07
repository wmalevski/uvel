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
                            {{ Breadcrumbs::render('wishlist') }}
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
                                        @if(session()->has('success'))
                                            <div class="alert alert-success">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <table class="cart-items haft-border">
                                            <thead>
                                                <tr class="top-labels">
                                                    <th class="text-left">Продукти</th>
                                                    <th>Цена</th>
                                                    <th>Премахни</th>
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
                                                                            <img src="@if($wishListItem->product->photos) {{ asset("uploads/products/" . $wishListItem->product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $wishListItem->product->name }}">
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
                                                        <a href="wishlist/delete/{{$wishListItem->id}}" class="delete-btn"><i class="fa fa-times"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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