<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editUserLabel">Промяна на потребител</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="users" data-type="edit" action="users/{{ $user->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Потребител: </label>
            <input type="text" class="form-control" value="{{ $user->email }}" name="email" placeholder="Имейл на потребителя:">
        </div>

        <div class="form-group">
            <label>Роля: </label>
            <select name="role" class="form-control">
                <option value="">Избери роля</option>
        
                @foreach(Bouncer::role()->all() as $role)
                    <option value="{{ $role->name }}" @if(Bouncer::is($user)->an($role->name)) selected @endif>{{ $role->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Магазин: </label>
            <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                <option value="">Избери магазин</option>
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @if($user->store_id == $store->id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" data-state="edit_state" class="action--state_button edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>