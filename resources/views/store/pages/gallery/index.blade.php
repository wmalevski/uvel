@extends('store.layouts.app', ['bodyClass' => 'templateGallery'])
@foreach($assetsArray['data'] as $idx => $asset)
    @if($asset['media_type'] == 'image')
        @php
            $mediaPaths = [
                'media_path' => $asset['media_path'],
                'thumbnail_path' => $asset['thumbnail_path'],
            ];
            foreach ($mediaPaths as $key => $path) {
                $relativePath = str_replace(storage_path('app/public'), '', $path);
                $url = Storage::url(ltrim($relativePath, '/'));
                $assetsArray['data'][$idx][$key] = $url;
            }
        @endphp
    @endif
@endforeach

@section('content')
<div id="content-wrapper-parent">
    <div id="content-wrapper">
        <div id="content" class="clearfix">
            <div id="breadcrumb" class="breadcrumb">
                    <div itemprop="breadcrumb" class="container">
                            <div class="row">
                                    <div class="col-md-24">
                                            {{ Breadcrumbs::render('gallery') }}
                                    </div>
                            </div>
                    </div>
            </div>
            <section class="content">
                <div class="container">
                    <div id="page-header" class="col-md-24">
                        <h1 id="page-title">Галерия</h1>
                    </div>
                    <div id="col-main" class="col-md-24 clearfix">
                        <div class="page page-gallery">
                            @if($assets->count())
                            <section id="albumNav">
                                <ul>
                                        <li>
                                            <a href="{{ route('store_gallery') }}" class="btn btn-outline-warning {{ is_null(request()->get('jewel_id')) ? 'active' : '' }}">Всички</a>
                                        </li>
                                    @foreach($jewels as $jewel)
                                        <li>
                                            <a href="{{ route('store_gallery', ['jewel_id' => $jewel->id]) }}" class="btn btn-outline-warning {{ request()->get('jewel_id') == $jewel->id ? 'active' : '' }}">{{$jewel->name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                            @endif
                            <section>
                                <div id="uvel_gallery">
                                    @if($assets->count() == 0)
                                        <h1 class="text-center">
                                            <span style="font-size:40px;padding:15px;">💁</span>Няма намерени резултати
                                        </h1>
                                    @endif
                                </div>
                            </section>
                          {{ $assets->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@foreach($assetsArray['data'] as $idx => $asset)
    @if($asset['media_type'] == 'image')
        @php
            $mediaPaths = [
                'media_path' => $asset['media_path'],
                'thumbnail_path' => $asset['thumbnail_path'],
            ];
            foreach ($mediaPaths as $key => $path) {
                $relativePath = str_replace(storage_path('app/public'), '', $path);
                $url = Storage::url(ltrim($relativePath, '/'));
                $assetsArray['data'][$idx][$key] = $url;
            }
        @endphp
    @endif
@endforeach

@push('scoped-scripts')
<script type="text/javascript">
    $(document).ready((event) => {
        "use strict";

        const gallery          = {{ Illuminate\Support\Js::from($assetsArray) }};
        const customOrderUrl   = "{{ route('custom_order') }}";
        const sanitizedGallery = [];


        function basketEvent( _, item ) {
            const imageUrl             = item.src;
            const customData           = item.customData;
            const filename             = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);
            const archiveDateObj       = new Date(customData.archiveDate);
            const mediaType            = customData.mediaType;
            const thumbnail            = mediaType == 'video'? item.thumbs.url.l1.la: null;
            const formattedArchiveDate = archiveDateObj.toISOString();
            const uniqueNumber         = customData.uniqueNumber;
            const queryParams          = `?blob=${filename}&size=${customData.size}&archiveDate=${formattedArchiveDate}&weight=${customData.weight}&jewelType=${customData.type}&media=${mediaType}&thumb=${thumbnail}&uniqueNumber=${uniqueNumber}`;

            window.location.href = customOrderUrl + queryParams;
        }

        for (const i in gallery.data) {
            const item = gallery.data[i];
            sanitizedGallery.push({
                src: item.media_path,
                srct: item.thumbnail_path,
                title: item.title,
                album: item.type.id,
                customData: {
                    weight: item.weight,
                    type: item.type.name,
                    mediaType: item.media_type,
                    size: item.size,
                    archiveDate: item.archive_date,
                    uniqueNumber: item.unique_number,
                },
            });
        }

        if ( gallery.total ) {
            const $nanoInit = $('#uvel_gallery').nanogallery2({
                items: sanitizedGallery,
                fnShoppingCartUpdated: basketEvent,
                thumbnailToolbarImage: {
                    topLeft: 'shoppingcart'
                },
                thumbnailBorderHorizontal: 1,
                thumbnailBorderVertical: 1,
                thumbnailWidth: '300 XS100 LA400 XL500',
                thumbnailHeight: '200 XS80 LA250 XL350',
                thumbnailDisplayTransition: 'slideUp2',
                thumbnailDisplayTransitionDuration: 500,
                thumbnailDisplayInterval: 30,
                thumbnailWaitImageLoaded: true,
                thumbnailHoverEffect2: [{
                        name: 'image_scale_1.00_1.20',
                        duration: 500,
                    }],
                locationHash: false,
                viewerGallery: 'bottom',
                viewerTheme : {
                    background:             '#000',
                    barBackground:          'rgba(4, 4, 4, 0.2)',
                    barBorder:              '0px solid #111',
                    barColor:               '#fff',
                    barDescriptionColor:    '#ccc',
                },
                viewerTools:            {
                    "topLeft":    "pageCounter",
                    "topRight":   "playPauseButton, zoomButton, fullscreenButton, closeButton",
                },
                /* This piece of code is kept in case the client request custom cart buttons in gallery
                fnThumbnailInit: ($e) => {
                    const thumb    = $e.find('.nGY2GThumbnailSub');
                    const fragment = document.createDocumentFragment();
                    const btn      = document.createElement('a');
                    const icon     = document.createElement('i');

                    btn.classList = "btn btn-outline gallery-cart";
                    $(btn).css({
                        position: 'absolute',
                        top: 5,
                        left: 5,
                    });
                    icon.classList = "fa fa-shopping-cart";
                    btn.appendChild(icon);
                    fragment.appendChild(btn);
                    thumb.append(fragment);

                  $('.gallery-cart').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const imageUrl = $(e.currentTarget).siblings().find('.nGY2GThumbnailImg').attr('src');
                    const filename = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);

                    window.location.href = customOrderUrl + '?blob=' + filename;
                  });
                },
                */
            });
        }
    });
</script>
@endpush
