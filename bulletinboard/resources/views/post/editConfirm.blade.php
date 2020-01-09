@extends('layouts.app')

@section('title','Post Update Confirm')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Post Update Confirmation</h3>
        </div>
        <div class="card-body">
            <div class="col-md-8 mx-auto">
                <form action="/post/{{$post_id}}" method="post">
                    @csrf

                    <div class="form-group row">
                        <label for="title" class="col-md-4">Title</label>
                        <label for="title" class="col-md-4">{{$title}}</label>
                        <input type="hidden" name="title" value="{{$title}}">
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-md-4">Description</label>
                        <label for="desc" class="col-md-4">{{$desc}}</label>
                        <input type="hidden" name="desc" value="{{$desc}}">
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-md-4">Status</label>
                        <div class="col-md-4">
                            <input type="checkbox" id="status" disabled="disabled" class="form-check-input col-md-1" value="{{$status}}"
                                @if($status=='1' ) {{"checked"}} @endif>
                                <input type="hidden" class="form-control col-md-6" name="status" id="status" value="{{$status}}">
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mr-4">Update</button>
                            <a href="" class="btn btn-dark">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
