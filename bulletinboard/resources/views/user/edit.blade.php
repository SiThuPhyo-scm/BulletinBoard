@extends('layouts.app')

@section('title','Update User')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update User</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <form action="/user/edit/{{ $users->id }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="col-12 col-sm-12 col-md-12 col-lg-8 mx-auto">
                            <div class="row form-group">
                                <label for="name" class="col-4 col-sm-4 col-md-4">Name</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <input type="text" name="name" class="form-control" value="{{ $users->name }}">
                                    @error('name')
                                        <label for="validation" class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                            </div>
                            <div class="row form-group">
                                <label for="email" class="col-4 col-sm-4 col-md-4">Email Address</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <input type="text" name="email" class="form-control" value="{{ $users->email }}">
                                    @error('email')
                                        <label for="validation" class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                            </div>
                            <div class="row form-group">
                                <label for="type" class="col-4 col-sm-4 col-md-4">Type</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    @if ($users->type=='0')
                                        <select name="type" id="type" name="type" class="form-control">
                                            <option value=0 @if( $users->type=='0' ) {{"selected"}} @endif>Admin</option>
                                            <option value=1 @if( $users->type=='1' ) {{"selected"}} @endif>User</option>
                                        </select>
                                        @else
                                            <select name="type" id="type" name="type" class="form-control">
                                                <option value="1"selected>User</option>
                                            </select>
                                    @endif
                                    @error('type')
                                        <label for="validation" class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                                <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                            </div>
                            <div class="row form-group">
                                <label for="phone" class="col-4 col-sm-4 col-md-4">Phone</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <input type="text" name="phone" class="form-control" value="{{ $users->phone }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="dob" class="col-4 col-sm-4 col-md-4">Date of Birth</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <input type="date" name="dob" class="form-control" value="{{ $users->dob }}">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="address" class="col-4 col-sm-4 col-md-4">Address</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <textarea name="address" id="address"  class="form-control">{{ $users->address }}</textarea>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="profile" class="col-4 col-sm-4 col-md-4">Profile</label>
                                <div class="col-7 col-sm-7 col-md-7">
                                    <input type="file" name="profileImg" class="form-control" onchange="readURL(this);">
                                    @error('profileImg')
                                        <label for="validation" class="text-danger">{{ $message }}</label>
                                    @enderror
                                    <img src="{{ $users->profile }}" id="stp" class="mt-3 profile-img" alt="profile">
                                </div>
                                <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                            </div>
                            <div class="row form-group">
                                <a href="/user/password/{{$users->id}}">Change Password</a>
                            </div>
                            <div class="form-group">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary  mr-4">Confirm</button>
                                    <button type="reset" class="btn btn-light">Clear</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-sm-0">
                    <img src="{{ $users->profile }}" class="profile-img profile" alt="profile">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
