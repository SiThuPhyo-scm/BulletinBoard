@extends('layouts.app')

@section('title','Create User')
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
            <h3>Create User</h3>
        </div>
        <div class="card-body">
            <div class="col-md-6 mx-auto">
                <form action="/user/createConfirm" method="POST">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4">Name</label>
                        <div class="col-md-7">
                            <input type="text" id="name" name="name" class="form-control">
                            @error('name')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4">Email</label>
                        <div class="col-md-7">
                            <input type="text" id="email" name="email" class="form-control">
                            @error('email')
                                <label for="vlaidation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4">Password</label>
                        <div class="col-md-7">
                            <input type="password" id="password" name="password" class="form-control">
                            @error('password')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-md-4">Confirm Password</label>
                        <div class="col-md-7">
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                            @error('confirm_password')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="type" class="col-md-4">Type</label>
                        <div class="col-md-7">
                            <select name="type" id="type" class="form-control">
                                <option value="" disabled selected>-- Choose Authority --</option>
                                <option value=0>Admin</option>
                                <option value=1>User</option>
                            </select>
                            @error('type')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-md-4">Phone</label>
                        <div class="col-md-7">
                            <input type="text" id="phone" name="phone" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="dob" class="col-md-4">Date of Birth</label>
                        <div class="col-md-7">
                            <input type="date" id="dob" name="dob" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-md-4">Address</label>
                        <div class="col-md-7">
                            <textarea name="address" id="address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="profile" class="col-md-4">Profile</label>
                        <div class="col-md-7">
                            <input type="file" name="profile" class="form-control" onchange="readURL(this);">
                            @error('profile')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                            <img src="http://placehold.it/180" id="stp" class="mt-3" alt="profile">
                        </div>
                        <label for="require" class="col-md-1 col-form-label text-danger text-md-left">*</label>
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
@endguest
@endsection
