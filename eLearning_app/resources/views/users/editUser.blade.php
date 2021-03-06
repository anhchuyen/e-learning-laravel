@extends('layouts.app')

@section('content')

<div class="edit-error-sentence">
@if ($errors->has('avatar'))
    <h4 class="">{{$errors->first('avatar')}}</h4>
@endif
@if ($errors->has('name'))
    <h4 class="">{{$errors->first('name')}}</h4>
@endif
@if ($errors->has('email'))
    <h4 class="">{{$errors->first('email')}}</h4>
@endif
</div>

<form action="/user/store/edit/{{$user->id}}" method="POST" enctype="multipart/form-data" class="m-10">
@csrf
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12 editUser-avatar">
                    <p><img src="{{$user->avatar}}" style="width:200px;height:200px;"></p>
                </div>
                <div class="col-md-12 editUser-avatar" >
                    <p><input type="file" name="avatar" class="editUser-inputFile"></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mr-5 ml-5">
            
                <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}">
                </div>   

        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="text-center">
        <a href="/home" class="btn btn-warning mt-3 mr-3">Back</a>
        <button class="create-post btn btn-primary mt-3" type="submit">Edit</button>
    </div>
</form>
@endsection