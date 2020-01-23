@extends('layouts.app')

@section('title','Update Post')
@section('script')
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endsection
@section('style')
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Update Post</h3>
        </div>
        <div class="card-body">
            <div class="col-md-10 col-lg-8 mx-auto">
                <form action="/post/edit/{{$post_detail->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="title" class="col-3 col-sm-3 col-md-4">Title</label>
                        <div class="col-8 col-sm-8 col-md-6">
                            <input type="text" id="title" name="title" class="form-control" value="{{$post_detail->title}}">
                            @error('title')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-2 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="desc" class="col-3 col-sm-3 col-md-4">Description</label>
                        <div class="col-8 col-sm-8 col-md-6">
                            <textarea name="desc" id="desc" class="form-control">{{$post_detail->description}}</textarea>
                            @error('desc')
                                <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <label for="require" class="col-1 col-sm-1 col-md-2 col-form-label text-danger text-md-left">*</label>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-3 col-sm-3 col-md-4">Status</label>
                        <div class="col-8 col-sm-8 col-md-6">
                        <input type="checkbox" data-toggle="toggle" data-on=" " data-off=" " data-style="round" data-onstyle="success" data-offstyle="danger" name="status" id="status" data-toggle="toggle" data-onstyle="success" class="form-check-input ml-2" value="1"
                            @if(old('status', $post_detail->status)=='1' ) {{"checked"}} @endif>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mr-4">Confirm</button>
                            <button type="reset" class="btn btn-light">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
