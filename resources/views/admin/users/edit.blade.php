<div class="editModalWrapper">
<div class="modal-header">
    <h5 class="modal-title" id="editUserLabel">Промяна на потребител</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="POST" name="edit" action="/users/{{ $user->id }}">
    <input name="_method" type="hidden" value="PUT">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $user->name }}" name="name" placeholder="Име на потребителя:">
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
            <select name="store_id" class="form-control">
                <option value="">Избери магазин</option>
        
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @if($user->store_id == $store->id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            @foreach(Bouncer::ability()->get() as $permission)
            <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                <input type="checkbox" id="inputCall{{ $permission->id }}" 
                @if($user->can($permission->name)) checked @endif name="permissions[]" class="peer">
                <label for="inputCall{{ $permission->id }}" class="peers peer-greed js-sb ai-c">
                    <span class="peer peer-greed">{{ $permission->title }}</span>
                </label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="edit-btn-modal btn btn-primary">Промени</button>
    </div>
</form>
</div>