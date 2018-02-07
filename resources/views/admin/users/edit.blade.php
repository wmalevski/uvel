<div class="modal-header">
    <h5 class="modal-title" id="editUserLabel">Промяна на потребител</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="PUT" action="/ajax/users/{{ $user->id }}">
    <div class="modal-body">    
        <div class="info-cont">
        </div>

        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" value="{{ $user->name }}" id="1" name="name" placeholder="Име на потребителя:">
        </div>

        <div class="form-group">
            <label for="1">Вид: </label>
            <input type="text" class="form-control" value="{{ $user->name }}" id="1" name="location" placeholder="Вид:">
        </div>

        <div class="form-group">
            <label>Магазин: </label>
            <select name="material" class="form-control">
                <option value="">Избер магазин</option>
        
                @foreach($stores as $store)
                    <option value="{{ $store->id }}" @if(Auth::user()->store == $store->id) selected @endif>{{ $store->name }} - {{ $store->location }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" class="btn btn-primary">Промени</button>
    </div>
</form>