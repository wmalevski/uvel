<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1024, initial-scale=1.0, user-scalable=yes"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    <style>
        .select2 {
            width: 100% !important;
        }

        #loader {
            transition: all .3s ease-in-out;
            opacity: 1;
            visibility: visible;
            position: fixed;
            height: 100vh;
            width: 100%;
            background: #fff;
            z-index: 90000
        }

        #loader.fadeOut {
            opacity: 0;
            visibility: hidden
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: calc(50% - 20px);
            left: calc(50% - 20px);
            background-color: #333;
            border-radius: 100%;
            -webkit-animation: sk-scaleout 1s infinite ease-in-out;
            animation: sk-scaleout 1s infinite ease-in-out
        }

        @-webkit-keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                opacity: 0
            }
        }

        @keyframes sk-scaleout {
            0% {
                -webkit-transform: scale(0);
                transform: scale(0)
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                opacity: 0
            }
        }
        div.sidebar-logo a.sidebar-link div.logo{
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
    <link href="{{ URL::asset('../css/admin-panel.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('select2.min.css') }}" rel="stylesheet">

</head>

<body class="app">
<div id="loader" class="nojs">
    <div class="spinner"></div>
</div>
<script type="text/javascript">
    window.addEventListener('load', function () {
        var loader = document.getElementById('loader');

        setTimeout(function () {
            loader.classList.add('fadeOut');
        }, 300);
    });

</script>
<div>
    <div class="sidebar">
        <div class="sidebar-inner">
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="{{ route('admin') }}" class="td-n">
                            <div class="logo">
                                <img src="{{ App\Setting::get('website_logo') }}" alt="" style="max-height: 64px;">
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 {{ request()->routeIs('admin') }}">
                    <a class="sidebar-link" href="{{ route('admin') }}" default>
              <span class="icon-holder">
                <i class="c-blue-500 ti-home"></i>
              </span>
                        <span class="title">Начало</span>
                    </a>
                </li>

                @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['cashier', 'manager', 'admin']))
                    <li class="nav-item dropdown {{ request()->routeIs(['selling', 'payments', 'online_selling']) }}">
                        <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="ti-shopping-cart"></i>
              </span>
                            <span class="title">Продажби</span>
                            <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->routeIs('selling') }}">
                                <a class="sidebar-link" href="{{ route('selling') }}">Продажба</a>
                            </li>

                            <li class="{{ request()->routeIs('payments') }}">
                                <a class="sidebar-link" href="{{ route('payments') }}">Завършени</a>
                            </li>

                            <li class="{{ request()->routeIs('online_selling') }}">
                                <a class="sidebar-link" href="{{ route('online_selling') }}">Онлайн магазин</a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, [ 'manager', 'admin']))
                    <li class="nav-item {{ request()->routeIs('discounts') }}">
                        <a class="sidebar-link" href="{{ route('discounts') }}">
                <span class="icon-holder">
                  <i class=" ti-money"></i>
                </span>
                            <span class="title">Отстъпки</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item dropdown {{ request()->routeIs(['stores', 'daily_reports', 'expenses', 'expenses_types', 'create_report', 'income', 'income_types']) }}">
                    <a class="sidebar-link" href="javascript:void(0);">
                <span class="icon-holder">
                  <i class=" ti-location-arrow"></i>
                </span>
                        <span class="title">Магазини</span>
                        <span class="arrow">
                  <i class="ti-angle-right"></i>
                </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('stores') }}">
                            <a class="sidebar-link" href="{{ route('stores') }}">Магазини</a>
                        </li>
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                        <li class="{{ request()->routeIs(['daily_reports', 'create_report']) }}">
                            <a class="sidebar-link" href="{{ route('daily_reports') }}">Дневни отчети</a>
                        </li>
                        @endif
                        <li class="{{ request()->routeIs('income') }}">
                            <a class="sidebar-link" href="{{ route('income') }}">Приходи</a>
                        </li>
                        <li class="{{ request()->routeIs('expenses') }}">
                            <a class="sidebar-link" href="{{ route('expenses') }}">Разходи</a>
                        </li>
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role,['admin', 'storehouse']))
                        <li class="{{ request()->routeIs('income_types') }}">
                            <a class="sidebar-link" href="{{ route('income_types') }}">Типове приходи</a>
                        </li>
                        <li class="{{ request()->routeIs('expenses_types') }}">
                            <a class="sidebar-link" href="{{ route('expenses_types') }}">Типове разходи</a>
                        </li>
                        @endif
                    </ul>
                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <li class="nav-item {{ request()->routeIs('admin_blog') }}">
                    <a class="sidebar-link" href="{{ route('admin_blog') }}">
                <span class="icon-holder">
                  <i class=" ti-pencil"></i>
                </span>
                        <span class="title">Блог</span>
                    </a>
                </li>
<!--                 <li class="nav-item {{ request()->routeIs('slides') }}">
                    <a class="sidebar-link" href="{{ route('slides') }}">
                <span class="icon-holder">
                  <i class="ti-image"></i>
                </span>
                        <span class="title">Слайдове</span>
                    </a>
                </li> -->
                <li class="nav-item {{ request()->routeIs(['prices', 'view_price']) }}">
                    <a class="sidebar-link" href="{{ route('prices') }}">
                  <span class="icon-holder">
                    <i class=" ti-money"></i>
                  </span>
                        <span class="title">Цени</span>
                    </a>
                </li>
                @endif
                @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, [ 'manager', 'admin']))
                    <li class="nav-item dropdown {{ request()->routeIs(['users', 'substitutions', 'partners', 'partner_materials']) }}">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                      <i class=" ti-user"></i>
                    </span>
                            <span class="title">Потребители</span>
                            <span class="arrow">
                      <i class="ti-angle-right"></i>
                    </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->routeIs('users') }}">
                                <a class="sidebar-link" href="{{ route('users') }}">Потребители</a>
                            </li>

                            <li class="{{ request()->routeIs('substitutions') }}">
                                <a class="sidebar-link" href="{{ route('substitutions') }}">Замествания</a>
                            </li>

                            <li class="{{ request()->routeIs(['partners','partner_materials']) }}">
                                <a class="sidebar-link" href="{{ route('partners') }}">Партньори</a>
                            </li>

                        </ul>
                    </li>
                @endif

                <li class="nav-item dropdown {{ request()->routeIs(['custom_orders', 'model_orders_web', 'orders']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder">
                      <i class=" ti-truck"></i>
                    </span>
                        <span class="title">Поръчки</span>
                        <span class="arrow">
                      <i class="ti-angle-right"></i>
                    </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('orders') }}">
                            <a class="sidebar-link" href="{{ route('orders') }}">Поръчки</a>
                        </li>
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['cashier', 'manager', 'admin']))
                            <li class="{{ request()->routeIs('custom_orders') }}">
                                <a class="sidebar-link" href="{{ route('custom_orders') }}">По модел на клиента</a>
                            </li>

                            <li class="{{ request()->routeIs('model_orders_web') }}">
                                <a class="sidebar-link" href="{{ route('model_orders_web') }}">По готов модел</a>
                            </li>
                        @endif

                    </ul>
                </li>

                @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['storehouse', 'admin']))
                    <li class="nav-item {{ request()->routeIs('jewels') }}">
                        <a class="sidebar-link" href="{{ route('jewels') }}">
                <span class="icon-holder">
                  <i class=" ti-package"></i>
                </span>
                            <span class="title">Бижута</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item dropdown {{ request()->routeIs(['admin_models', 'show_model_reviews']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                  <span class="icon-holder">
                    <i class="ti-blackboard"></i>
                  </span>
                        <span class="title">Модели</span>
                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('admin_models') }}">
                            <a class="sidebar-link" href="{{ route('admin_models') }}">Наличности</a>
                        </li>
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                        <li class="{{ request()->routeIs('show_model_reviews') }}">
                            <a class="sidebar-link" href="{{ route('show_model_reviews') }}">Ревюта</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <li class="nav-item {{ request()->routeIs('reviews') }}">
                    <a class="sidebar-link" href="{{ route('reviews') }}">
                  <span class="icon-holder">
                    <i class="ti-archive"></i>
                  </span>
                        <span class="title">Ревюта</span>
                    </a>
                </li>
                @endif

                <li class="nav-item dropdown {{ request()->routeIs(['admin_products', 'products_travelling', 'products_reviews']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                  <span class="icon-holder">
                    <i class="ti-package"></i>
                  </span>
                        <span class="title">Продукти</span>
                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('admin_products') }}">
                            <a class="sidebar-link" href="{{ route('admin_products') }}">Наличности</a>
                        </li>
                        <li class="{{ request()->routeIs('products_travelling') }}">
                            <a class="sidebar-link" href="{{ route('products_travelling') }}">На път</a>
                        </li>
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                        <li class="{{ request()->routeIs('products_reviews') }}">
                            <a class="sidebar-link" href="{{ route('products_reviews') }}">Ревюта</a>
                        </li>
                        @endif
                    </ul>
                </li>

                    <li class="nav-item dropdown {{ request()->routeIs(['products_others', 'products_others_types', 'show_products_others_reviews']) }}">
                        <a class="dropdown-toggle" href="javascript:void(0);">
                  <span class="icon-holder">
                    <i class="ti-folder"></i>
                  </span>
                            <span class="title">Кутии/Икони</span>
                            <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="{{ request()->routeIs('products_others') }}">
                                <a class="sidebar-link" href="{{ route('products_others') }}">Наличности</a>
                            </li>
                            @if(in_array(\Illuminate\Support\Facades\Auth::user()->role,['admin', 'storehouse']))
                                <li class="{{ request()->routeIs('products_others_types') }}">
                                    <a class="sidebar-link" href="{{ route('products_others_types') }}">Типове</a>
                                </li>
                            @endif
                            @if(in_array(\Illuminate\Support\Facades\Auth::user()->role,['admin', 'manager']))
                                <li class="{{ request()->routeIs('show_products_others_reviews') }}">
                                    <a class="sidebar-link" href="{{ route('show_products_others_reviews') }}">Ревюта</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                <li class="nav-item dropdown {{ request()->routeIs(['materials_types', 'materials', 'materials_quantity', 'materials_travelling']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                  <span class="icon-holder">
                    <i class="ti-magnet"></i>
                  </span>
                        <span class="title">Материали</span>
                        <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role,['admin', 'storehouse']))
                            <li class="{{ request()->routeIs('materials_types') }}">
                                <a class="sidebar-link" href="{{ route('materials_types') }}">Типове</a>
                            </li>

                            <li class="{{ request()->routeIs('materials') }}">
                                <a class="sidebar-link" href="{{ route('materials') }}">Видове</a>
                            </li>
                        @endif
                            <li class="{{ request()->routeIs('materials_quantity') }}">
                                <a class="sidebar-link" href="{{ route('materials_quantity') }}">Наличности</a>
                            </li>
                        <li class="{{ request()->routeIs('materials_travelling') }}">
                            <a class="sidebar-link" href="{{ route('materials_travelling') }}">На път</a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item dropdown {{ request()->routeIs(['stones', 'nomenclatures', 'sizes', 'stones', 'contours', 'styles']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class=" ti-hummer"></i>
              </span>
                        <span class="title">Камъни</span>
                        <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
                            <li class="{{ request()->routeIs('nomenclatures') }}">
                                <a class="sidebar-link" href="{{ route('nomenclatures') }}">Номенклатури</a>
                            </li>
                        @endif
                            <li class="{{ request()->routeIs('stones') }}">
                                <a class="sidebar-link" href="{{ route('stones') }}">Камъни</a>
                            </li>
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
                            <li class="{{ request()->routeIs('sizes') }}">
                                <a class="sidebar-link" href="{{ route('sizes') }}">Размери</a>
                            </li>
                            <li class="{{ request()->routeIs('contours') }}">
                                <a class="sidebar-link" href="{{ route('contours') }}">Контури</a>
                            </li>
                            <li class="{{ request()->routeIs('styles') }}">
                                <a class="sidebar-link" href="{{ route('styles') }}">Стилове</a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item dropdown {{ request()->routeIs(['repair_types', 'repairs']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class=" ti-slice"></i>
              </span>
                        <span class="title">Ремонтни дейности</span>
                        <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                        <li class="{{ request()->routeIs('repair_types') }}">
                            <a class="sidebar-link" href="{{ route('repair_types') }}">Видове</a>
                        </li>
                        @endif
                        <li class="{{ request()->routeIs('repairs') }}">
                            <a class="sidebar-link" href="{{ route('repairs') }}">Ремонти</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown {{ request()->routeIs(['daily_reports', 'expenses', 'create_report', 'selling_report_export', 'materials_reports', 'mtravelling_reports', 'products_reports', 'productstravelling_reports', 'income', 'cash_register']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class=" ti-slice"></i>
              </span>
                        <span class="title">Справки</span>
                        <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
                    </a>
                    <ul class="dropdown-menu">
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, [ 'manager', 'admin', 'storehouse']))
                            <li class="{{ request()->routeIs(['selling_report_export']) }}">
                                <a class="sidebar-link" href="{{ route('selling_report_export') }}">Продажби -
                                    Експорт</a>
                            </li>
                            <li class="{{ request()->routeIs(['daily_reports', 'create_report']) }}">
                                <a class="sidebar-link" href="{{ route('daily_reports') }}">Дневни</a>
                            </li>
                            <li class="{{ request()->routeIs(['materials_reports']) }}">
                                <a class="sidebar-link" href="{{ route('materials_reports') }}">Материали</a>
                            </li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            <li class="{{ request()->routeIs(['mtravelling_reports']) }}">
                                <a class="sidebar-link" href="{{ route('mtravelling_reports') }}">Материали на път</a>
                            </li>
                        @endif
                        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, [ 'manager', 'admin', 'storehouse']))
                            <li class="{{ request()->routeIs(['products_reports']) }}">
                                <a class="sidebar-link" href="{{ route('products_reports') }}">Продукти</a>
                            </li>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            <li class="{{ request()->routeIs(['productstravelling_reports']) }}">
                                <a class="sidebar-link" href="{{ route('productstravelling_reports') }}">Продукти на път</a>
                            </li>

                            <li class="{{ request()->routeIs(['cash_register']) }}">
                                <a class="sidebar-link" href="{{ route('cash_register') }}">Движения</a>
                            </li>

                        @endif
                        <li class="{{ request()->routeIs('income') }}">
                            <a class="sidebar-link" href="{{ route('income') }}">Приходи</a>
                        </li>
                        <li class="{{ request()->routeIs('expenses') }}">
                            <a class="sidebar-link" href="{{ route('expenses') }}">Разходи</a>
                        </li>
                    </ul>
                </li>

                @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                <li class="nav-item dropdown {{ request()->routeIs(['stock_prices', 'currencies', 'cashgroups', 'cms', 'system_settings']) }}">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                <span class="icon-holder">
                  <i class="ti-settings"></i>
                </span>
                        <span class="title">Настройки</span>
                        <span class="arrow">
                  <i class="ti-angle-right"></i>
                </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ request()->routeIs('stock_prices') }}">
                            <a class="sidebar-link" href="{{ route('stock_prices') }}">Борсови цени</a>
                        </li>
                        <li class="{{ request()->routeIs('currencies') }}">
                            <a class="sidebar-link" href="{{ route('currencies') }}">Валути и курсове</a>
                        </li>
                        <li class="{{ request()->routeIs('cashgroups') }}">
                            <a class="sidebar-link" href="{{ route('cashgroups') }}">Касови групи</a>
                        </li>
                        <li class="{{ request()->routeIs('cms') }}">
                            <a class="sidebar-link" href="{{ route('cms') }}">Информационни блокове</a>
                        </li>
                        <li class="{{ request()->routeIs('system_settings') }}">
                            <a class="sidebar-link" href="{{ route('system_settings') }}">Системни Настройки</a>
                        </li>
                    </ul>
                </li>
                @endif

                <li class="nav-item {{ request()->routeIs('mailchimp') }}">
                    <a class="sidebar-link" href="{{ route('mailchimp') }}">
            <span class="icon-holder">
              <i class=" ti-email"></i>
            </span>
                        <span class="title">MailChimp</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-left">
                    <li>
                        <a id="sidebar-toggle" class="sidebar-toggle" href="javascript:void(0);">
                            <i class="ti-menu"></i>
                        </a>
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                            <div class="peer mR-10">
                                <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                            </div>
                            <div class="peer">
                                <span class="fsz-sm c-grey-900">{{ Auth::user()->email }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu fsz-sm">
                            <li>
                                <a href="{{ route('admin_logout') }}"
                                   onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"
                                   class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                    <i class="ti-power-off mR-10"></i>
                                    <span>Изход</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1">
                            <div class="peer">
                                <span class="fsz-sm c-grey-900">{{ App\User::withTrashed()->find(Auth::user()->id)->store->name }} </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <main class="main-content bgc-grey-100">
            <div id="mainContent">
                @yield('content')
            </div>
        </main>
    </div>
</div>
<form id="logout-form" action="{{ route('admin_logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>


<script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/tablesort.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/tablesort.number.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/tablesort.date.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('vendor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('bundle.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/custom.js') }}"></script>

<!-- include summernote css/js -->
<link href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>


<script>
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 300,
            popover: {
                image: [],
                link: [],
                air: []
            }
        });

        $('body').on('click', '#blog_lng_edit a', function (e) {
            e.preventDefault();
            console.log('clicked');
            $(this).tab('show');
        })
    });
</script>


@yield('footer-scripts')
</body>
</html>
