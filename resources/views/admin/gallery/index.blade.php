@use('Illuminate\Support\Facades\Storage')
@extends('admin.layout')
@section('content')

@if($errors->any())
  <div class="d-flex flex-column justify-content-center align-items-center p-2">
    @foreach($errors->all() as $error)
      <p class="alert-danger">{{$error}}</p>
    @endforeach
  </div>
@endif

<div class="d-flex gap-10">
  <h3> Галерия</h3>
  <div class="d-flex gap-10">
    {{-- Store image modal component --}}
    <x-admin.forms.create 
      form-header="Добави снимка в раздел Галерия" 
      form-id="formGalleryImage" 
      form-name="formGalleryImage" 
      form-action="{{ route('gallery_upload_image') }}" 
      form-label="label" 
      form-trigger-text="Добави снимка" 
      class="m-2 text-uppercase"
    >
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="title">Заглавие</label>
          <input type="text" name="title" id="title" class="w-100" required>
        </div>
        <div class="form-group col-md-6">
          <label for="description">Описание</label>
          <input type="text" name="description" id="description" class="w-100" required>
        </div>
        <div class="form-group col-md-12">
          <div class="drop-area d-flex justify-content-between" name="add">
            <input type="file" name="images[]" class="drop-area-input" id="image" data-locale="{{ $locale }}" multiple accept="image/*">
            <label class="button" for="image">Избери снимка/и...</label>
            <div class="drop-area-gallery"></div>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="unique_number">Уникален номер</label>
          <input type="text" name="unique_number" id="unique_number" placeholder="{{ rand(1111111111, 9999999999) }}" />
        </div>
        <div class="form-group col-md-6">
          <label for="weight">Тегло (гр.)</label>
          <input type="number" step="0.1" name="weight" id="weight" placeholder="0.0" />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="size">Размер (мм)</label>
          <input type="number" name="size" id="size">
        </div>

        <div class="form-group col-md-6">
          <label for="type">Вид Бижу</label>
          <select name="type" id="type">
            @foreach($jewels as $jewel)
              <option value="{{$jewel->id}}">{{$jewel->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="archive_date">Дата</label>
          {{-- <input type="date" name="archive_date"/> --}}
          <input type="text" name="archive_date" class="form-control bdc-grey-200" placeholder="Дата: " data-date-autoclose="true" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"/>
        </div>
      </div>
      <input type="hidden" name="media_type" value="image">
    </x-admin.forms.create>

    {{-- Store video modal component --}}
    <x-admin.forms.create 
      form-header="Добави видео в раздел Галерия" 
      form-id="formGalleryVideo" 
      form-name="formGalleryVideo" 
      form-action="{{ route('gallery_upload_video') }}" 
      form-label="label" 
      form-trigger-text="Добави видео" 
      class="m-2 text-uppercase"
    >
      <div class="form-group">
        <div class="form-row">
          <div class="d-flex flex-column w-100 justify-content-center align-content-center">
            <label for="title">Заглавие</label>
            <input type="text" name="title" required></input>
          </div>
        </div>
        <div class="form-row">
          <div class="d-flex flex-column w-100 justify-content-center align-content-center">
            <label for="youtube_link">Youtube (Постави копираният линк тук):</label>
            <input type="text" name="youtube_link" required></input>
          </div>
        </div>

        <div class="form-row">
          <label for="type">Вид Бижу</label>
          <select name="type" id="type">
            @foreach($jewels as $jewel)
              <option value="{{$jewel->id}}">{{$jewel->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="video_unique_number">Уникален номер</label>
          <input type="text" name="video_unique_number" id="video_unique_number" placeholder="{{ rand(1111111111, 9999999999) }}" />
        </div>
        <div class="form-group col-md-6">
          <label for="video_weight">Тегло (гр.)</label>
          <input type="number" step="0.1" name="video_weight" id="video_weight" placeholder="0.0" />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="video_size">Размер (мм)</label>
          <input type="number" name="video_size" id="video_size">
        </div>

        <div class="form-group col-md-6">
          <label for="video_type">Вид Бижу</label>
          <select name="video_type" id="video_type">
            @foreach($jewels as $jewel)
              <option value="{{$jewel->id}}">{{$jewel->name}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="video_archive_date">Дата</label>
          <input type="text" name="video_archive_date" class="form-control bdc-grey-200" placeholder="Дата: " data-date-autoclose="true" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{Carbon\Carbon::now()->format('Y-m-d')}}"/>
        </div>
      </div>
      <input type="hidden" name="media_type" value="video">
    </x-admin.forms.create>
  </div>
</div>

<p>Преглед на галерия.</p>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Заглавие</th>
      <th scope="col">Тип</th>
      <th scope="col">Thumbnail</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
  @forelse ($gallery as $item)
    <tr>
      <th scope="row">{{$item->id}}</th>
      <td>{{$item->title ?? 'N/A'}}</td>
      <td>{{__('frontend.'.$item->media_type)}}</td>
      <td>
        @if (isset($item->thumbnail_path))
            @php
              if ( $item->media_type === 'image' ) {
                $thumbRel = str_replace(storage_path('app/public'), '', $item->thumbnail_path);
                $thumbUrl = Storage::url(ltrim($thumbRel, '/'));
                $mediaRel = str_replace(storage_path('app/public'), '', $item->media_path);
                $mediaUrl = Storage::url(ltrim($mediaRel, '/'));
              } else {
                $thumbUrl = $item->thumbnail_path;
                $mediaUrl = $item->media_path;
              }
            @endphp
          <a href="{{$mediaUrl}}" target="_blank">
            <img src="{{$thumbUrl}}" height="100" width="100">
          </a>
        @else
          N/A
        @endif
      </td>
      <td>
          @php $loggedUser = \Illuminate\Support\Facades\Auth::user() @endphp
          @if(isAdmin($loggedUser))
            <span data-url="gallery/delete/{{$item->id}}" class="delete-btn">
              <i class="c-brown-500 ti-trash"></i>
            </span>
          @endif
      </td>
    </tr>
  @empty
    <tr colspan="100"><h1 class="text-center"><span style="font-size:40px;padding:15px;">&#128129;</span>Няма намерени резултати</h1></tr>
  @endforelse
  </tbody>
</table>

{{ $gallery->links() }}

@endsection
