@extends('store.layouts.app', ['bodyClass' => 'templateGallery'])

@foreach($imagesArray['data'] as $idx => $asset)
    @if($asset['media_type'] == 'image')
        @php
            $mediaPaths = [
                'media_path' => $asset['media_path'],
                'thumbnail_path' => $asset['thumbnail_path'],
            ];
            foreach ($mediaPaths as $key => $path) {
                $relativePath = str_replace(storage_path('app/public'), '', $path);
                $url = Storage::url(ltrim($relativePath, '/'));
                $imagesArray['data'][$idx][$key] = $url;
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
                            @if($images->count())
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

                                    @if($videosCount)
                                        <li>
                                            <a href="{{ route('store_gallery', ['videos' => true]) }}" class="btn btn-outline-warning {{ request()->get('videos') == true ? 'active' : '' }}">{{__('Видео')}}</a>
                                        </li>
                                    @endif
                                </ul>
                            </section>
                            @endif
                            <section>
                                <div id="uvel_gallery">
                                    @if($images->count() == 0)
                                        <h1 class="text-center">
                                            <span style="font-size:40px;padding:15px;">💁</span>Няма намерени резултати
                                        </h1>
                                    @endif
                                    @php
                                        $groupedAssets = collect($imagesArray['data'])->groupBy(function($asset) {
                                            return Carbon\Carbon::parse($asset['archive_date'])->format('m-d-y H:i:s');
                                        });
                                    @endphp
                                    @foreach($groupedAssets as $archiveDate => $asset)
                                        @php
                                            $fancyboxTimestamp = Carbon\Carbon::createFromFormat('m-d-y H:i:s', $archiveDate)->timestamp;
                                        @endphp
                                        <a href="{{ $asset->first()['media_path'] }}" data-fancybox="gallery-{{ $fancyboxTimestamp }}" data-caption="{{ $asset->first()['title'] }}" class="gallery-item">
                                            <img src="{{ $asset->first()['thumbnail_path'] }}" />
                                            <div class="image-footer-content">
                                                <span>Тегло: {{ $asset->first()['weight'] }}гр.</span>
                                                <span>{{ $asset->first()['title'] }}</span>
                                                @if(!is_null($asset->first()['size']))<span>Размер: {{ $asset->first()['size'] }}</span>@endif
                                            </div>
                                            <span class="basket">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            </span>

                                            <input name="archiveData[{{$fancyboxTimestamp}}]" type="hidden"
                                                data-weight="{{$asset->first()['weight']}}"
                                                data-size="{{$asset->first()['size']}}"
                                                data-type="{{$asset->first()['type']['name']}}"
                                                data-archiveDate="{{$asset->first()['archive_date']}}"
                                                data-uniqueNum="{{$asset->first()['unique_number']}}"
                                                data-src="{{$asset->first()['media_path']}}"
                                                data-mediaType="{{$asset->first()['media_type']}}"
                                                data-thumbnail="{{$asset->first()['thumbnail_path']}}"
                                            />
                                        </a>

                                        <div style="display: none;">
                                            @foreach($asset->slice(1) as $asset)
                                                <a href="{{ $asset['media_path'] }}" data-fancybox="gallery-{{ $fancyboxTimestamp }}" data-caption="{{ $asset['title'] }}">
                                                    <img src="{{ $asset['thumbnail_path'] }}" />
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                          {{ $images->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scoped-scripts')
<script type="text/javascript">
    $(document).ready((event) => {
        "use strict";

        const gallery          = {{ Illuminate\Support\Js::from($imagesArray) }};
        const customOrderUrl   = "{{ route('custom_order') }}";

        function basketEventCallback( data ) {
            const imageUrl             = data.src;
            const mediaType            = data.mediatype;
            const filename             = mediaType.toLowerCase() == 'image' ? imageUrl.substring(imageUrl.lastIndexOf('/') + 1) : data.thumbnail;
            const archiveDateObj       = new Date(data.archivedate);
            const formattedArchiveDate = archiveDateObj.toISOString();
            const uniqueNumber         = data.uniquenum;
            const queryParams          = `?blob=${filename}&size=${data.size}&archiveDate=${formattedArchiveDate}&weight=${data.weight}&jewelType=${data.type}&media=${mediaType}&uniqueNumber=${uniqueNumber}`;

            window.location.href = customOrderUrl + queryParams;
        }

        if ( gallery.total ) {
            const fancyBox = Fancybox.bind("[data-fancybox]", {});

            $(".gallery-item .basket").on("click", e => {
                e.preventDefault();
                const $target = $(e.currentTarget);
                const $imageMeta = $target.siblings('[name^="archiveData"]').data();
                return basketEventCallback($imageMeta);
            })
        }
    });
</script>
@endpush
