@extends('layouts.app')

@section('tile','Change Password')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Change Password</h3>
        </div>
        <div class="card-body">
            <div class="col-md-10 col-lg-8 mx-auto">
                <form action="pass"></form>
                <div class="form-group row">
                    <label for="oldpsw" class="col-4 col-sm-4 col-md-4">Old Password</label>
                    <div class="col-6 col-sm-6 col-md-6">
                        <input type="password" name="oldpsw" class="form-control">
                    </div>
                    <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                </div>
                <div class="form-group row">
                    <label for="newpsw" class="col-4 col-sm-4 col-md-4">New Password</label>
                    <div class="col-6 col-sm-6 col-md-6">
                        <input type="password" name="newpsw" class="form-control">
                    </div>
                    <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                </div>
                <div class="form-group row">
                    <label for="pswconfirm" class="col-4 col-sm-4 col-md-4">Password Confrim</label>
                    <div class="col-6 col-sm-6 col-md-6">
                        <input type="password" name="pswconfirm" class="form-control">
                    </div>
                    <label for="require" class="col-1 col-sm-1 col-md-1 col-form-label text-danger text-md-left">*</label>
                </div>
                <div class="form-group row">
                    <div class="col-12 col-md-8 mx-auto">
                        <button type="submit" class="btn btn-primary  mr-4">Change</button>
                        <a href="" class="btn btn-dark">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
