@extends('layouts.app')

@section('title','Post Create')
@section('content')

<div id="createPost">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Create New Post</h3>
            </div>
            <div class="card-body">
                <div class="col-md-8 mx-auto">
                    <form action="/post/create" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="title" class="col-md-2">Title</label>
                        <input type="text" id="title" name="title" class="form-control col-md-6" value="{{old('title', session('title'))}}">
                        @if ($errors->has('title'))
                            <label class="text-danger col-md-4">{{ $errors->first('title') }}</label>
                        @endif
                    </div>

                    <div class="form-group row">
                        <label for="desc" class="col-md-2">Description</label>
                        <textarea name="desc" id="desc" class="form-control col-md-6">{{old('desc', session('desc'))}}</textarea>
                        @if ($errors->has('desc'))
                            <label class="text-danger col-md-4">{{ $errors->first('desc') }}</label>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mr-4">Confirm</button>
                            <button type="reset" class="btn btn-danger">Clear</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
