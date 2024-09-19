<div>
    @if(in_array(Auth::user()->role, ['admin', 'storehouse']))
      <button type="button" {{ $attributes->class(['add-btn btn btn-primary']) }} data-form-type="add" data-form="{{$formName}}" data-toggle="modal" data-target="#{{$formId}}">{{$formTriggerText}}</button>
    @endif

    <div class="modal fade" id="{{$formId}}" role="dialog" aria-labelledby="{{$formLabel}}" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="{{$formLabel}}">{{$formHeader}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <form method="POST" action="{{$formAction}}" name="{{$formName}}" data-type="add" autocomplete="off" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="info-cont"></div>
              {{ csrf_field() }}
              {{ $slot }}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
              <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>