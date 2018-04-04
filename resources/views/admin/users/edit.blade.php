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
        
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($user->roles->first()['id'] == $role->id) selected @endif>{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Магазин: </label>
            <select name="store" class="form-control">
                <option value="">Избери магазин</option>
        
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @if($user->store == $store->id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="edit" class="btn btn-primary" data-dismiss="modal">Промени</button>
    </div>
</form>