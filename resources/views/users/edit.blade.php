@extends('layouts.app')
@section('content')
<form action="{{route('users.update',['user'=>$user->id])}}" method="Post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="row">
            <div class="col-md-4">
                <h5>select a different avatar:</h5>
                <img src="{{$user->image ? $user->image->url() : '' }}" alt="avatar" class="img-thumbnail avatar my-3">
                <input type="file" name="avatar" id="avatar" class="form-control-file">
            </div>
            <div class="col-md-8">
                <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" class="form-control">
                </div>
                <p>{{__('example_with_value' , ['name' => $user->name])}}</p>
            </div>
            
            <div class="form-group mt-3">
                <label for="">language : </label>
                <select name="locale" id="language" class="form-control">
                    @foreach (App\Models\User::LOCALES as $locale => $label)
                    <option value="{{$locale}}" {{$user->locale === $locale ? 'selected' : ''}}>{{$label}}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-warning btn-block my-3">update profile</button>
        </div>
    </form>
@endsection