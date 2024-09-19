@extends('store.layouts.app', ['bodyClass' => 'templateGallery'])

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
            <div class="container">
                <div id="page-header" class="col-md-24">
                    <h1 id="page-title">Галерия</h1>
                </div>
                <div id="col-main" class="col-md-24 clearfix">
                    <div class="page page-gallery">
                      <section>
                        <div id="uvel_gallery">
                            @foreach($assetsArray['data'] as $asset)
                                @switch($asset['media_type'])
                                    @case('image')
                                        @php
                                            $mediaPaths = [
                                                'media_path' => $asset['media_path'],
                                                'thumbnail_path' => $asset['thumbnail_path'],
                                            ];
                                            $urls = [];
                                            foreach ($mediaPaths as $key=>$path) {
                                                $relativePath = str_replace(storage_path('app/public'), '', $path);
                                                $url = Storage::url(ltrim($relativePath, '/'));
                                                $urls[$key] = $url;
                                            }
                                        @endphp
                                        <a href="{{ $urls['media_path'] }}" data-ngthumb="{{ $urls['thumbnail_path'] }}" data-ngdesc="{{ $asset['title'] }}">
                                            {{ $asset['title'] }}
                                        </a>
                                        @break
                                    @case('video')
                                        <a href="{{ $asset['media_path'] }}" data-ngthumb="{{ asset($asset['thumbnail_path']) }}" data-ngdesc="{{ $asset['title'] }}">
                                            {{ $asset['title'] }}
                                        </a>
                                        @break
                                    @default
                                        @break
                                @endswitch
                            @endforeach
                        </div>
                      </section>
                      {{ $assets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scoped-scripts')
<script type="text/javascript">
    $(document).ready((event) => {
        "use strict";
        const galleryMeta = {{ Illuminate\Support\Js::from($assetsArray) }};

        $('#uvel_gallery').nanogallery2({
            // Thumbnail configuration
            thumbnailWidth: '300 XS100 LA400 XL500',
            thumbnailHeight: '200 XS80 LA250 XL350',
            thumbnailDisplayTransition: 'slideUp2',
            thumbnailDisplayTransitionDuration: 500,
            thumbnailDisplayInterval: 30,
            thumbnailWaitImageLoaded: true,
            thumbnailBorderHorizontal: 0,
            thumbnailBorderVertical: 0,

            // Navigation
            galleryTheme: 'light',
            thumbnailToolbarImage: { topLeft: 'select' },
            viewerGallery: 'bottom',
        });
    });
</script>
@endpush
