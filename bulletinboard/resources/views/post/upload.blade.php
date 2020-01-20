@extends('layouts.app')

@section('title','Upload CSV')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Upload CSV File</h3>
        </div>
        <div class="card-body">
            <div class="col-md-10 col-lg-8 mx-auto">
                <label for="file">Import File From:</label>
                <form action="/csv/upload" method="POST" enctype="multipart/form-data" class="border border-dark p-5">
                @csrf
                    <div class="row from-group">
                        <input type="file" id="file" name="file" class="form-control-file col-md-5">
                        @error('file')
                            <label class="text-danger">{{ $message }}</label>
                        @enderror
                        @if(Session::has('invalid'))
                            <div class="alert alert-danger">
                                {{ Session::get('invalid') }}
                                @php
                                    Session::forget('invalid');
                                @endphp
                            </div>
                        @endif
                    </div>
                    <div class="row form-group text-center">
                        <button type="submit" class="btn btn-primary btn-md mt-4">Import File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
