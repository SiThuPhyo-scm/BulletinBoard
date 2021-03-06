@extends('layouts.app')

@section('title','Change Password')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Change Password</h3>
        </div>
        <div class="card-body">
            <div class="col-md-10 col-lg-8 mx-auto">
                <form action="/user/passwordchange/{{ $user_id }}" method="POST">
                @csrf
                    <div class="form-group row">
                        <label for="oldpassword" class="col-4 col-sm-4 col-md-4">Old Password</label>
                        <div class="col-6 col-sm-6 col-md-6">
                            <input type="password" name="oldpassword" class="form-control">
                            @error('oldpassword')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="newpassword" class="col-4 col-sm-4 col-md-4">New Password</label>
                        <div class="col-6 col-sm-6 col-md-6">
                            <input type="password" name="newpassword" class="form-control">
                            @error('newpassword')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="confirmpassword" class="col-4 col-sm-4 col-md-4">Password Confrim</label>
                        <div class="col-6 col-sm-6 col-md-6">
                            <input type="password" name="confirmpassword" class="form-control">
                            @error('confirmpassword')
                                <label for="validation" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                    </div>
                    @if(Session::has('Incorrect'))
                        <div class="alert alert-danger text-md-center">
                            {{ Session::get('Incorrect') }}
                            @php
                                Session::forget('Incorrect');
                            @endphp
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-8 col-md-8 mx-auto">
                            <button type="submit" class="btn btn-primary  mr-4">Change</button>
                            <button type="reset" class="btn btn-light">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
