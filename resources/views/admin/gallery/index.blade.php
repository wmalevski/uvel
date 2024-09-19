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
      <div class="form-group">
        <label for="title">Заглавие</label>
        <input type="text" name="title" id="title" class="w-100" required>
      </div>
      <div class="form-group">
        <label for="alt_text">Добавете кратък текст описващ снимката (SEO friendly)</label>
        <input type="text" name="alt_text" id="alt_text" class="w-100" required>
      </div>
      <div class="form-group">
        <div class="drop-area d-flex justify-content-between" name="add">
          <input type="file" name="images" class="drop-area-input" id="image" data-locale="{{ $locale }}" accept="image/*">
          <label class="button" for="image">Избери снимка...</label>
          <div class="drop-area-gallery"></div>
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
