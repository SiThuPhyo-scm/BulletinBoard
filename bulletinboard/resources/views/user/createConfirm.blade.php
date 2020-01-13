@extends('layouts.app')

@section('title','Create User Confirm')
@section('content')
@guest
<div class="card">
    <div class="card-header">
        <h3>Sorry my friend. Plase Login!!!!!</h3>
    </div>
</div>
@else
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create User Confirmation</h3>
        </div>
        <div class="card-body">
            <div class="col-md-10 mx-auto">
                <form action="/user/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <label for="name" class="col-md-4">Name</label>
                                <label for="name" class="col-md-6">{{ $name }}</label>
                                <input type="hidden" name="name" value="{{ $name }}">
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4">Email</label>
                                <label for="email" class="col-md-6">{{ $email }}</label>
                                <input type="hidden" name="email" value="{{ $email }}">
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4">Password</label>
                                <label for="password" class="col-md-6">{{ $pwd_hide }}</label>
                                <input type="hidden" name="password" value="{{ $pwd }}">
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-md-4">Type</label>
                                @if($type == 1 || $type == null)
                                    <label for="type" class="col-md-6">User</label>
                                    @else
                                        <label for="type" class="col-md-6">Admin</label>
                                @endif
                                <input type="hidden" name="type" value="{{ $type }}">
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-4">Phone</label>
                                <label for="phone" class="col-md-6">{{ $phone }}</label>
                                <input type="hidden" name="phone" value="{{ $phone }}">
                            </div>
                            <div class="form-group row">
                                <label for="dob" class="col-md-4">Date of Birth</label>
                                <label for="dob" class="col-md-6">{{ $dob }}</label>
                                <input type="hidden" name="dob" value="{{ $dob }}">
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-4">Address</label>
                                <label for="address" class="col-md-6">{{ $address }}</label>
                                <input type="hidden" name="address" value="{{ $address }}">
                            </div>
                            <div class="form-group">
                                <div class="ml-4">
                                    <button type="submit" class="btn btn-primary  mr-4">Create</button>
                                    <a href="/user/create" class="btn btn-dark">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" id="profile" name="filename" value="{{ $filename }}" class="form-control" onchange="readURL(this);">
                            <img src="/img/tempProfile/{{$filename}}" class="profile-img" alt="profile">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection
