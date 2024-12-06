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
  <h3>Групи</h3>
  <div class="d-flex gap-10">
    <x-admin.forms.create 
      form-header="Добави група" 
      form-id="addUserGroup" 
      form-name="addUserGroup" 
      form-action="{{ route('user_groups_create') }}" 
      form-label="label" 
      form-trigger-text="Добави" 
      class="m-2 text-uppercase"
    >
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="title">Име</label>
          <input type="text" name="name" id="name" class="w-100 form-control" required value="{{old('name')}}">
        </div>
        <div class="form-group col-md-6">
            <label for="domain">Домейн</label>
            <input type="text" name="domain" id="domain" class="w-100 form-control" required value="{{old('domain')}}" pattern="^@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Домейнът трябва да започва с @ и да следва този формат @example.com">
        </div>
      </div>
    </x-admin.forms.create>
  </div>
</div>

<p>Преглед на групи</p>
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Име</th>
      <th scope="col">Домейн</th>
      <th scope="col">Действия</th>
    </tr>
  </thead>
  <tbody>
  @forelse ($groups as $group)
    <tr>
      <th scope="row">{{$group->id}}</th>
      <td>{{$group->name ?? 'N/A'}}</td>
      <td>{{$group->domain ?? 'N/A'}}</td>
      <td>
          @php $loggedUser = \Illuminate\Support\Facades\Auth::user() @endphp
          @if(isAdmin($loggedUser))
            <span data-url="users/groups/delete/{{$group->id}}" class="delete-btn">
              <i class="c-brown-500 ti-trash"></i>
            </span>
          @endif
      </td>
    </tr>
  @empty
    <tr colspan="100"><h1 class="text-center"><span style="font-size:40px;padding:15px;">&#128129;</span>{{__('Няма намерени резултати')}}</h1></tr>
  @endforelse
  </tbody>
</table>

@endsection
