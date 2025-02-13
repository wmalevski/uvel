<div class="modal-header">
    <h5 class="modal-title" id="addUserLabel">Добавяне на потребител</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form method="POST" action="users" name="users" data-type="add" autocomplete="off">
        
    <div class="modal-body">    
        <div class="info-cont"></div>
        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Имейл/Име: </label>
            <input type="text" class="form-control" id="email-1" name="email" placeholder="Имейл/Име на потребител:">
        </div>

        <div class="form-group">
            <label for="1">Парола: </label>
            <input id="password" type="password" class="form-control" name="password" placeholder="Парола:" required>
        </div>

        <div class="form-group">
            <label for="password-confirm">Повтори парола: </label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Повтори паролата:" required>
        </div>
    
        <div class="form-group">
            <label>Роля: </label>
            <select name="role" class="form-control">
                <option value="">Избери роля</option>
        
                @foreach(Bouncer::role()->all() as $role)
                    <option value="{{ $role->name }}">{{ $role->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Магазин: </label>
            <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                <option value="">Избери магазин</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
    </div>
</form>
