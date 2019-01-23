<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <style>
    .select2{
      width: 100% !important;
    }

    .nav-item.active{
      background: #d2d2d2;
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
    window.addEventListener('load', function(){
      var loader = document.getElementById('loader');

      setTimeout(function() {
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
                <div class="peers ai-c fxw-nw">
                  <div class="peer">
                    <div class="logo">
                      <img src="assets/static/images/logo.png" alt="">
                    </div>
                  </div>
                  <div class="peer peer-greed">
                    <h5 class="lh-1 mB-0 logo-text">UVEL</h5>
                  </div>
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
          <li class="nav-item mT-30 {{ Active::ifRouteIn('admin') }}">
            <a class="sidebar-link" href="{{ route('admin') }}" default>
              <span class="icon-holder">
                <i class="c-blue-500 ti-home"></i>
              </span>
              <span class="title">Начало</span>
            </a>
          </li>

          <li class="nav-item dropdown {{ Active::ifRouteIn(['selling', 'payments', 'online_selling']) }}">
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
              <li {{ Active::ifRouteIn('selling') }}>
                <a class="sidebar-link" href="{{ route('selling') }}">Продажба</a>
              </li>

              <li {{ Active::ifRouteIn('payments') }}>
                <a class="sidebar-link" href="{{ route('payments') }}">Завършени</a>
              </li>

              <li {{ Active::ifRouteIn('online_selling') }}>
                <a class="sidebar-link" href="{{ route('online_selling') }}">Онлайн магазин</a>
              </li>

            </ul>
          </li>

          <li class="nav-item {{ Active::ifRouteIn('discounts') }}">
            <a class="sidebar-link" href="{{ route('discounts') }}">
              <span class="icon-holder">
                <i class=" ti-money"></i>
              </span>
              <span class="title">Отстъпки</span>
            </a>
          </li>
          <li class="nav-item dropdown {{ Active::ifRouteIn(['stores', 'daily_reports', 'expenses', 'expenses_types']) }}">
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
                <li>
                  <a class="sidebar-link" href="{{ route('stores') }}">Магазини</a>
                </li>
                <li>
                  <a class="sidebar-link" href="{{ route('daily_reports') }}">Дневни отчети</a>
                </li>
                <li>
                  <a class="sidebar-link" href="{{ route('expenses') }}">Разходи</a>
                </li>
                <li>
                  <a class="sidebar-link" href="{{ route('expenses_types') }}">Типове разходи</a>
                </li>
              </ul>
            </li>

            <li class="nav-item {{ Active::ifRouteIn('admin_blog') }}">
              <a class="sidebar-link" href="{{ route('admin_blog') }}">
                <span class="icon-holder">
                  <i class=" ti-pencil"></i>
                </span>
                <span class="title">Блог</span>
              </a>
            </li>
            <li class="nav-item {{ Active::ifRouteIn('prices') }}">
                <a class="sidebar-link" href="{{ route('prices') }}">
                  <span class="icon-holder">
                    <i class=" ti-money"></i>
                  </span>
                  <span class="title">Цени</span>
                </a>
              </li>

                <li class="nav-item dropdown {{ Active::ifRouteIn(['users', 'substitutions', 'partners']) }}">
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
                    <li {{ Active::ifRouteIn('users') }}>
                      <a class="sidebar-link" href="{{ route('users') }}">Потребители</a>
                    </li>

                    {{-- @if(Auth::user()->hasRole('admin')) --}}
                    <li {{ Active::ifRouteIn('substitutions') }}>
                      <a class="sidebar-link" href="{{ route('substitutions') }}">Замествания</a>
                    </li>
                    {{-- @endif --}}

                    <li {{ Active::ifRouteIn('partners') }}>
                      <a class="sidebar-link" href="{{ route('partners') }}">Партньори</a>
                    </li>

                  </ul>
                </li>


                <li class="nav-item dropdown {{ Active::ifRouteIn(['custom_orders', 'model_orders_web', 'orders']) }}">
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
                    <li {{ Active::ifRouteIn('custom_orders') }}>
                      <a class="sidebar-link" href="{{ route('custom_orders') }}">По модел на клиента</a>
                    </li>

                    {{-- @if(Auth::user()->hasRole('admin')) --}}
                    <li {{ Active::ifRouteIn('model_orders_web') }}>
                      <a class="sidebar-link" href="{{ route('model_orders_web') }}">По готов модел</a>
                    </li>
                    {{-- @endif --}}

                  </ul>
                </li>


            <li class="nav-item {{ Active::ifRouteIn('jewels') }}">
              <a class="sidebar-link" href="{{ route('jewels') }}">
                <span class="icon-holder">
                  <i class=" ti-package"></i>
                </span>
                <span class="title">Бижута</span>
              </a>
            </li>

              <li class="nav-item dropdown {{ Active::ifRouteIn(['admin_models', 'show_model_reviews']) }}">
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
                  <li {{ Active::ifRouteIn('admin_models') }}>
                    <a class="sidebar-link" href="{{ route('admin_models') }}">Наличности</a>
                  </li>
                  <li {{ Active::ifRouteIn('show_model_reviews') }}>
                    <a class="sidebar-link" href="{{ route('show_model_reviews') }}">Ревюта</a>
                  </li>
                </ul>
              </li>

              <li class="nav-item {{ Active::ifRouteIn('reviews') }}">
                <a class="sidebar-link" href="{{ route('reviews') }}">
                  <span class="icon-holder">
                    <i class="ti-archive"></i>
                  </span>
                  <span class="title">Ревюта</span>
                </a>
              </li>

              <li class="nav-item dropdown {{ Active::ifRouteIn(['admin_products', 'products_travelling', 'products_reviews']) }}">
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
                  <li {{ Active::ifRouteIn('admin_products') }}>
                    <a class="sidebar-link" href="{{ route('admin_products') }}">Наличности</a>
                  </li>
                  <li {{ Active::ifRouteIn('products_travelling') }}>
                    <a class="sidebar-link" href="{{ route('products_travelling') }}">На път</a>
                  </li>
                  <li {{ Active::ifRouteIn('products_reviews') }}>
                    <a class="sidebar-link" href="{{ route('products_reviews') }}">Ревюта</a>
                  </li>
                </ul>
              </li>

              <li class="nav-item dropdown {{ Active::ifRouteIn(['products_others', 'products_others_types', 'show_products_others_reviews']) }}">
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
                  <li {{ Active::ifRouteIn('products_others') }}>
                    <a class="sidebar-link" href="{{ route('products_others') }}">Наличности</a>
                  </li>
                  <li {{ Active::ifRouteIn('products_others_types') }}>
                    <a class="sidebar-link" href="{{ route('products_others_types') }}">Типове</a>
                  </li>
                  <li {{ Active::ifRouteIn('show_products_others_reviews') }}>
                    <a class="sidebar-link" href="{{ route('show_products_others_reviews') }}">Ревюта</a>
                  </li>
                </ul>
              </li>

              <li class="nav-item dropdown {{ Active::ifRouteIn(['materials_types', 'materials', 'materials_quantity', 'materials_travelling']) }}">
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
                  <li {{ Active::ifRouteIn('materials_types') }}>
                    <a class="sidebar-link" href="{{ route('materials_types') }}">Типове</a>
                  </li>

                  <li {{ Active::ifRouteIn('materials') }}>
                    <a class="sidebar-link" href="{{ route('materials') }}">Видове</a>
                  </li>

                  {{-- @if(Auth::user()->hasRole('admin')) --}}
                  <li {{ Active::ifRouteIn('materials_quantity') }}>
                    <a class="sidebar-link" href="{{ route('materials_quantity') }}">Наличности</a>
                  </li>
                  {{-- @endif --}}

                  <li {{ Active::ifRouteIn('materials_travelling') }}>
                    <a class="sidebar-link" href="{{ route('materials_travelling') }}">На път</a>
                  </li>

                </ul>
              </li>
          <li class="nav-item dropdown {{ Active::ifRouteIn(['stones', 'sizes', 'stones', 'contours', 'styles']) }}">
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
              <li {{ Active::ifRouteIn('stones') }}>
                <a class="sidebar-link" href="{{ route('stones') }}">Камъни</a>
              </li>
              <li {{ Active::ifRouteIn('sizes') }}>
                <a class="sidebar-link" href="{{ route('sizes') }}">Размери</a>
              </li>
              <li {{ Active::ifRouteIn('contours') }}>
                <a class="sidebar-link" href="{{ route('contours') }}">Контури</a>
              </li>
              <li {{ Active::ifRouteIn('styles') }}>
                <a class="sidebar-link" href="{{ route('styles') }}">Стилове</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown {{ Active::ifRouteIn(['repair_types', 'repairs']) }}">
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
              <li {{ Active::ifRouteIn('repair_types') }}>
                <a class="sidebar-link" href="{{ route('repair_types') }}">Видове</a>
              </li>
              <li {{ Active::ifRouteIn('repairs') }}>
                <a class="sidebar-link" href="{{ route('repairs') }}">Ремонти</a>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown {{ Active::ifRouteIn(['stock_prices', 'currencies']) }}">
              <span class="icon-holder">
                <i class=" ti-slice"></i>
              </span>
              <span class="title">Отчети</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="sidebar-link" href="{{ route('daily_reports') }}">Дневни</a>
              </li>
              <li>
                <a class="sidebar-link" href="{{ route('expenses') }}">Разходи</a>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown {{ Active::ifRouteIn('settings') }}">
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
              <li>
                <a class="sidebar-link" href="{{ route('stock_prices') }}">Борсови цени</a>
              </li>
              <li>
                <a class="sidebar-link" href="{{ route('currencies') }}">Валути и курсове</a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ Active::ifRouteIn('mailchimp') }}">
          <a class="sidebar-link" href="{{ route('mailchimp') }}">
            <span class="icon-holder">
              <i class=" ti-email"></i>
            </span>
            <span class="title">MailChimp</span>
          </a>
        </li>
          {{-- @endif --}}
          {{--  <li class="nav-item">
            <a class="sidebar-link" href="compose.html">
              <span class="icon-holder">
                <i class="c-blue-500 ti-pencil"></i>
              </span>
              <span class="title">Compose</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="sidebar-link" href="calendar.html">
              <span class="icon-holder">
                <i class="c-deep-orange-500 ti-calendar"></i>
              </span>
              <span class="title">Calendar</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="sidebar-link" href="chat.html">
              <span class="icon-holder">
                <i class="c-deep-purple-500 ti-comment-alt"></i>
              </span>
              <span class="title">Chat</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="sidebar-link" href="charts.html">
              <span class="icon-holder">
                <i class="c-indigo-500 ti-bar-chart"></i>
              </span>
              <span class="title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="sidebar-link" href="forms.html">
              <span class="icon-holder">
                <i class="c-light-blue-500 ti-pencil"></i>
              </span>
              <span class="title">Forms</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="sidebar-link" href="ui.html">
              <span class="icon-holder">
                <i class="c-pink-500 ti-palette"></i>
              </span>
              <span class="title">UI Elements</span>
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="c-orange-500 ti-layout-list-thumb"></i>
              </span>
              <span class="title">Tables</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="sidebar-link" href="basic-table.html">Basic Table</a>
              </li>
              <li>
                <a class="sidebar-link" href="datatable.html">Data Table</da>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="c-purple-500 ti-map"></i>
              </span>
              <span class="title">Maps</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="google-maps.html">Google Map</a>
              </li>
              <li>
                <a href="vector-maps.html">Vector Map</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="c-red-500 ti-files"></i>
              </span>
              <span class="title">Pages</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="sidebar-link" href="404.html">404</a>
              </li>
              <li>
                <a class="sidebar-link" href="500.html">500</a>
              </li>
              <li>
                <a class="sidebar-link" href="signin.html">Sign In</a>
              </li>
              <li>
                <a class="sidebar-link" href="signup.html">Sign Up</a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="dropdown-toggle" href="javascript:void(0);">
              <span class="icon-holder">
                <i class="c-teal-500 ti-view-list-alt"></i>
              </span>
              <span class="title">Multiple Levels</span>
              <span class="arrow">
                <i class="ti-angle-right"></i>
              </span>
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                  <span>Menu Item</span>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                  <span>Menu Item</span>
                  <span class="arrow">
                    <i class="ti-angle-right"></i>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="javascript:void(0);">Menu Item</a>
                  </li>
                  <li>
                    <a href="javascript:void(0);">Menu Item</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>  --}}
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
            {{-- <li class="search-box">
              <a class="search-toggle no-pdd-right" href="javascript:void(0);">
                <i class="search-icon ti-search pdd-right-10"></i>
                <i class="search-icon-close ti-close pdd-right-10"></i>
              </a>
            </li>
            <li class="search-input">
              <input class="form-control" type="text" placeholder="Search...">
            </li> --}}
            {{-- <li>
                {{ App\User::find(Auth::user()->id)->store->name }}
            </li> --}}
          </ul>
          <ul class="nav-right">
            {{--  <li class="notifications dropdown">
              <span class="counter bgc-red">3</span>
              <a href="" class="dropdown-toggle no-after" data-toggle="dropdown">
                <i class="ti-bell"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="pX-20 pY-15 bdB">
                  <i class="ti-bell pR-10"></i>
                  <span class="fsz-sm fw-600 c-grey-900">Notifications</span>
                </li>
                <li>
                  <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <span>
                            <span class="fw-500">John Doe</span>
                            <span class="c-grey-600">liked your
                              <span class="text-dark">post</span>
                            </span>
                          </span>
                          <p class="m-0">
                            <small class="fsz-xs">5 mins ago</small>
                          </p>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/2.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <span>
                            <span class="fw-500">Moo Doe</span>
                            <span class="c-grey-600">liked your
                              <span class="text-dark">cover image</span>
                            </span>
                          </span>
                          <p class="m-0">
                            <small class="fsz-xs">7 mins ago</small>
                          </p>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <span>
                            <span class="fw-500">Lee Doe</span>
                            <span class="c-grey-600">commented on your
                              <span class="text-dark">video</span>
                            </span>
                          </span>
                          <p class="m-0">
                            <small class="fsz-xs">10 mins ago</small>
                          </p>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="pX-20 pY-15 ta-c bdT">
                  <span>
                    <a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All Notifications
                      <i class="ti-angle-right fsz-xs mL-10"></i>
                    </a>
                  </span>
                </li>
              </ul>
            </li>
            <li class="notifications dropdown">
              <span class="counter bgc-blue">3</span>
              <a href="" class="dropdown-toggle no-after" data-toggle="dropdown">
                <i class="ti-email"></i>
              </a>
              <ul class="dropdown-menu">
                <li class="pX-20 pY-15 bdB">
                  <i class="ti-email pR-10"></i>
                  <span class="fsz-sm fw-600 c-grey-900">Emails</span>
                </li>
                <li>
                  <ul class="ovY-a pos-r scrollable lis-n p-0 m-0 fsz-sm">
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/1.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <div>
                            <div class="peers jc-sb fxw-nw mB-5">
                              <div class="peer">
                                <p class="fw-500 mB-0">John Doe</p>
                              </div>
                              <div class="peer">
                                <small class="fsz-xs">5 mins ago</small>
                              </div>
                            </div>
                            <span class="c-grey-600 fsz-sm">Want to create your own customized data generator for your app...</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/2.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <div>
                            <div class="peers jc-sb fxw-nw mB-5">
                              <div class="peer">
                                <p class="fw-500 mB-0">Moo Doe</p>
                              </div>
                              <div class="peer">
                                <small class="fsz-xs">15 mins ago</small>
                              </div>
                            </div>
                            <span class="c-grey-600 fsz-sm">Want to create your own customized data generator for your app...</span>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="" class="peers fxw-nw td-n p-20 bdB c-grey-800 cH-blue bgcH-grey-100">
                        <div class="peer mR-15">
                          <img class="w-3r bdrs-50p" src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
                        </div>
                        <div class="peer peer-greed">
                          <div>
                            <div class="peers jc-sb fxw-nw mB-5">
                              <div class="peer">
                                <p class="fw-500 mB-0">Lee Doe</p>
                              </div>
                              <div class="peer">
                                <small class="fsz-xs">25 mins ago</small>
                              </div>
                            </div>
                            <span class="c-grey-600 fsz-sm">Want to create your own customized data generator for your app...</span>
                          </div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="pX-20 pY-15 ta-c bdT">
                  <span>
                    <a href="" class="c-grey-600 cH-blue fsz-sm td-n">View All Email
                      <i class="fs-xs ti-angle-right mL-10"></i>
                    </a>
                  </span>
                </li>
              </ul>
            </li>  --}}
            <li class="dropdown">
              <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                <div class="peer mR-10">
                  <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                </div>
                <div class="peer">
                  <span class="fsz-sm c-grey-900">{{ Auth::user()->name }}</span>
                </div>
              </a>
              <ul class="dropdown-menu fsz-sm">
                {{--  <li>
                  <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                    <i class="ti-user mR-10"></i>
                    <span>Profile</span>
                  </a>
                </li>  --}}
                {{--  <li>
                  <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                    <i class="ti-email mR-10"></i>
                    <span>Messages</span>
                  </a>
                </li>  --}}
                <li>
                  <a href="{{ route('admin_logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
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
      <footer class="bdT ta-c p-30 lh-0 fsz-sm c-grey-600">
        <span>Copyright © 2017 Designed by
          <a href="https://colorlib.com" target="_blank" title="Colorlib">Colorlib</a>. All rights reserved.</span>
      </footer>
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
  <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>


  <script>
    $(document).ready(function() {
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
