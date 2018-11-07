@extends('store.layouts.app', ['bodyClass' => 'templateCustomersRegister'])

@section('content')

<div id="content-wrapper-parent">
    <div id="content-wrapper">  
        <!-- Content -->
        <div id="content" class="clearfix">        
            <div id="breadcrumb" class="breadcrumb">
                <div itemprop="breadcrumb" class="container">
                    <div class="row">
                        <div class="col-md-24">
                            <a href="./index.html" class="homepage-link" title="Back to the frontpage">Начало</a>
                            <span>/</span>
                            <span class="page-title">Поръчки</span>
                        </div>
                    </div>
                </div>
            </div>              
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Поръчки</h1> 
                        </div>

                        <div id="col-main" class="col-md-24 register-page clearfix">
                           <table class="table">
                            <thead>
                                <tr>
                                  <th scope="col">Име</th> 
                                  <th scope="col">Email</th> 
                                  <th scope="col">Телефон</th> 
                                  <th scope="col">Град</th> 
                                  <th scope="col">Модел</th> 
                                  <th scope="col">Дата</th>
                                  <th scope="col">Статус</th> 
                                </tr>
                              </thead>
                              <tbody>
                                  @foreach($orders as $order)
                                  <tr data-id="{{ $order->id }}">
                                    <td>{{ $order->user->name }}</td> 
                                    <td>{{ $order->user->email }}</td> 
                                    <td>{{ $order->user->phone }}</td> 
                                    <td>{{ $order->user->city }}</td> 
                                    <td>{{ $order->model->name }}</td> 
                                    <td>{{ $order->created_at }}</td> 
                                    <td>@if($order->status == 'pending') 
                                            <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Очаква одобрение</span> 
                                        @elseif($order->status == 'accepted') 
                                            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Приет/В процес</span> 
                                        @elseif($order->status == 'ready') 
                                            <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Върнат от работилница</span> 
                                        @else 
                                            <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Получен</span>  @endif</td> 
                                </tr>
                                  @endforeach
                              </tbody>     
                           </table>
                        </div>   
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection