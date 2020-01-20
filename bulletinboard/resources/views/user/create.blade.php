@extends('layouts.app')

@section('title','Create User')

@section('script')
<script src="{{ asset('js/custom.js') }}" defer></script>
@endsection

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Create User</h3>
        </div>
        <div class="card-body">
            <div class="col-md-8 mx-auto">
                <form action="/user/createConfirm" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-4 col-sm-4 col-md-4">Name</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                            @error('name')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-4 col-sm-4 col-md-4">Email</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
                            @error('email')
                                <label for="vlaidation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-4 col-sm-4 col-md-4">Password</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="password" id="password" name="password" class="form-control" vlaue="{{ old('pwd') }}">
                            @error('password')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-4 col-sm-4 col-md-4">Confirm Password</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                            @error('confirm_password')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-4 col-sm-4 col-md-4">Type</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <select name="type" id="type" class="form-control">
                                <option value="" disabled selected>-- Choose Authority --</option>
                                <option value=0 @if (old('type') === 0 ) {{"selected"}} @endif>Admin</option>
                                <option value=1 @if (old('type') === 1 ) {{"selected"}} @endif>User</option>
                            </select>
                            @error('type')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-4 col-sm-4 col-md-4">Phone</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dob" class="col-4 col-sm-4 col-md-4">Date of Birth</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-4 col-sm-4 col-md-4">Address</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="profile" class="col-4 col-sm-4 col-md-4">Profile</label>
                        <div class="col-7 col-sm-7 col-md-7">
                            <input type="file" id="profile" name="profileImg" value="{{old('profile')}}" class="form-control" onchange="readURL(this);">
                            @error('profileImg')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                            <img src="http://placehold.it/180" id="stp" class="mt-3 profile-img" alt="profile">
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary  mr-4">Confirm</button>
                            <button type="reset" class="btn btn-light">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
