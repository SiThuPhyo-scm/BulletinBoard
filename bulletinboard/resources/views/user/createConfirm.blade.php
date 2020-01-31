@extends('layouts.app')

@section('title','Create User Confirm')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create User Confirmation</h3>
        </div>
        <div class="card-body">
            <div class="col-12 col-sm-12 col-md-10 mx-auto">
                <form action="/user/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-7 col-sm-8 col-md-8">
                            <div class="form-group row">
                                <label for="name" class="col-4 col-sm-4 col-md-4">Name</label>
                                <label for="name" class="col-8 col-sm-8 col-md-6">{{ $user->name }}</label>
                                <input type="hidden" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-4 col-sm-4 col-md-4">Email</label>
                                <label for="email" class="col-8 col-sm-8 col-md-6">{{ $user->email }}</label>
                                <input type="hidden" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-4 col-sm-4 col-md-4">Password</label>
                                <label for="password" class="col-8 col-sm-8 col-md-6">{{ $user->pwd_hide }}</label>
                                <input type="hidden" name="password" value="{{ $user->pwd}}">
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-4 col-sm-4 col-md-4">Type</label>
                                @if($user->type == 1 || $user->type == null)
                                    <label for="type" class="col-8 col-sm-8 col-md-6">User</label>
                                    @else
                                        <label for="type" class="col-8 col-sm-8 col-md-6">Admin</label>
                                @endif
                                <input type="hidden" name="type" value="{{ $user->type }}">
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-4 col-sm-4 col-md-4">Phone</label>
                                <label for="phone" class="col-8 col-sm-8 col-md-6">{{ $user->phone }}</label>
                                <input type="hidden" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group row">
                                <label for="dob" class="col-4 col-sm-4 col-md-4">Date of Birth</label>
                                <label for="dob" class="col-8 col-sm-8 col-md-6">{{ $user->dob }}</label>
                                <input type="hidden" name="dob" value="{{ $user->dob }}">
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-4 col-sm-4 col-md-4">Address</label>
                                <label for="address" class="col-8 col-sm-8 col-md-6">{{ $user->address }}</label>
                                <input type="hidden" name="address" value="{{ $user->address }}">
                            </div>
                            <div class="form-group row">
                                <div class="ml-4">
                                    <button type="submit" class="btn btn-primary  mr-4">Create</button>
                                    <a href="/user/create" class="btn btn-dark">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 col-sm-4 col-md-4">
                            <input type="hidden" id="profile" name="filename" value="{{ $user->filename }}" class="form-control" onchange="readURL(this);">
                            <img src="/img/tempProfile/{{$user->filename}}" class="profile rounded-circle" alt="profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
