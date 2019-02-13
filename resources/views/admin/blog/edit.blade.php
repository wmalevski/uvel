<div class="editModalWrapper">
    <div class="modal-header">
        <h5 class="modal-title" id="fullEditRepairLabel">Промени статия</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    
    <form method="POST" data-type="edit" name="blog" action="blog/{{ $article->id }}">
        <input name="_method" type="hidden" value="PUT">
        <div class="modal-body">    
                <div class="info-cont">
                </div>
            {{ csrf_field() }}
            <!-- Nav tabs -->
            <ul id="blog_lng_edit" class="nav nav-tabs" role="tablist">
                @foreach(config('translatable.locales') as $locale => $language)
                    <li role="presentation" class="@if($loop->first)active @endif">
                        <a href="#{{$locale}}_store" aria-controls="{{$locale}}" role="tab" data-toggle="tab">{{$language}}</a>
                    </li>
                @endforeach
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                @foreach(config('translatable.locales') as $locale => $language)
                    <div role="tabpanel" class="tab-pane @if($loop->first)active @endif" id="{{$locale}}_store">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="1">Заглавие: </label>
                                <input type="text" class="form-control" id="1" name="title[{{$locale}}]" placeholder="Заглавие:" value="{{$article->translate($locale)->title}}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="1">Описание: </label>
                                <textarea class="form-control" name="excerpt[{{$locale}}]" rows="1">{{$article->translate($locale)->excerpt}}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="1">Съдържание: </label>
                                <textarea class="summernote" name="content[{{$locale}}]">{!!$article->translate($locale)->content!!}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="1">Снимка: </label>
                                <div class="drop-area" name="edit">
                                    <input type="file" name="images" class="drop-area-input" id="fileElem-edit-{{ $locale }}"
                                           data-locale="{{ $locale }}" accept="image/*">
                                    <label class="button" for="fileElem-edit-{{ $locale }}">Select some files</label>
                                    <div class="drop-area-gallery"></div>
                                </div>
                            </div>
                        </div>
                        <div class="uploaded-images-area">
                            @if($article->thumbnail())
                                <div class='image-wrapper'>
                                    <div class='close'>
                                        <span data-url="gallery/delete/{{$article->thumbnail()->id}}">&#215;</span>
                                    </div>
                                    <img src="{{ asset("uploads/blog/" . $article->thumbnail()->photo) }}" alt="" class="img-responsive" />  
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
            <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
        </div>
    </form>
</div>
