@extends('store.layouts.app', ['bodyClass' => 'templateGallery'])

@foreach($imagesArray['data'] as $idx => $asset)
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
                            <div class="gallery-actions">
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
                                <section id="searchBar">
                                    <form action="{{ url()->current() }}" method="GET" id="gallerySearchForm">
                                        <div class="search-controls">
                                            <div class="form-group">
                                                <input type="text" name="search" id="search" class="form-control" value="{{ !is_null($searchTerm) ? $searchTerm : '' }}" placeholder="{{__('Търсене')}}" aria-label="search" aria-describedby="inputGroup-sizing-default">
                                                <button class="form-control" type="submit">{{__('Търси')}}</button>
                                            </div>
                                        </div>
                                        <div class="search-criteria-btns">
                                            <span id="search-refresh-btn">
                                                <i class="fa fa-refresh"></i>
                                            </span>
                                            <div style="display:flex;flex-direction:column;">
                                                <div>
                                                    <input type="radio" id="criteria[1]" name="criteria" value="1">
                                                    <label for="criteria[1]">{!! __('Търси по дата (ГГММДД)') !!}</label>
                                                </div>
        
                                                <div>
                                                    <input type="radio" id="criteria[2]" name="criteria" value="2">
                                                    <label for="criteria[2]">{{__('Търси по номер')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </section>
                            </div>
                            <section>
                                <div id="uvel_gallery">
                                    @if($images->count() == 0)
                                        <h1 class="text-center">
                                            <span style="font-size:40px;padding:15px;">💁</span>Няма намерени резултати
                                        </h1>
                                    @endif
                                    @php
                                        $groupedAssets = collect($imagesArray['data'])->groupBy(function($asset) {
                                            return Carbon\Carbon::parse($asset['archive_date'])->format('y-m-d H:i:s');
                                        });
                                    @endphp
                                    @foreach($groupedAssets as $date => $asset)
                                        @php
                                            $timestamp = Carbon\Carbon::createFromFormat('y-m-d H:i:s', $date)->timestamp;
                                            $blob = $asset->first();
                                        @endphp
                                        <a href="{{ $blob['media_path'] }}" data-fancybox="gallery-{{ $timestamp }}" data-caption="{{ $blob['unique_number'] }}" class="gallery-item">
                                            @switch($blob['media_type'])
                                                @case('image')
                                                    <img src="{{ $blob['thumbnail_path'] }}"/>
                                                    @break
                                                @case('video')
                                                    <video>
                                                        <source src="{{$blob['media_path']}}">
                                                    </video>
                                                    @break
                                                @default
                                            @endswitch
                                            <div class="image-footer-content">
                                                <span>Тегло: {{ $blob['weight'] }}гр.</span>
                                                <span>{{ $blob['unique_number'] }}</span>
                                                @if(!is_null($blob['size']))<span>Размер: {{ $blob['size'] }}</span>@endif
                                            </div>
                                            <span class="basket">
                                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            </span>

                                            <input name="archiveData[{{$timestamp}}]" type="hidden"
                                                data-weight="{{$blob['weight']}}"
                                                data-size="{{$blob['size']}}"
                                                data-type="{{$blob['type']['name']}}"
                                                data-archiveDate="{{$blob['archive_date']}}"
                                                data-uniqueNum="{{$blob['unique_number']}}"
                                                data-src="{{$blob['media_path']}}"
                                                data-mediaType="{{$blob['media_type']}}"
                                                data-thumbnail="{{$blob['thumbnail_path']}}"
                                            />
                                        </a>

                                        <div style="display: none;">
                                            @foreach($asset->slice(1) as $asset)
                                                <a href="{{ $asset['media_path'] }}" data-fancybox="gallery-{{ $timestamp }}" data-caption="{{ $asset['unique_number'] }}">
                                                    <img src="{{ $asset['thumbnail_path'] }}" />
                                                </a>
                                                @switch($asset['media_type'])
                                                    @case('image')
                                                        <img src="{{ $blob['thumbnail_path'] }}"/>
                                                        @break
                                                    @case('video')
                                                        <video>
                                                            <source src="{{$blob['media_path']}}">
                                                        </video>
                                                        @break
                                                    @default
                                                @endswitch
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                          {{ $images->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@push('scoped-scripts')
    @once
        <script>
            var gallery        = {{ Illuminate\Support\Js::from($imagesArray) }},
                customOrderUrl = "{{ route('custom_order') }}";
        </script>
        <script src="{{ asset('js/modules/store/gallery/index.js') }}" type="text/javascript"></script>
    @endonce
@endpush

