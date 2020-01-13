@extends('layouts.app')

@section('title','User List')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>User List</h3>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <form action="/user/search" method="POST" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-md mb-4 mr-3" placeholder="Name">
                        <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-md mb-4 mr-3" placeholder="Email">
                        <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-md mb-4 mr-3" placeholder="Created From">
                        <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-md mb-4 mr-3" placeholder="Created To">
                        <button type="submit" class="btn btn-primary btn-md mb-4">Search</button>
                        <a href="/user/create" class="btn btn-primary btn-md mb-4 ml-4">Add</a>
                    </div>
                </form>
            </div>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
            @endif
            <div class="row justinfy-content-center">
                <table class="table table-bordered">
                    <thead class="text-nowrap">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created User</th>
                        <th>Phone</th>
                        <th>Birth Date</th>
                        <th>Created Date</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td><button class="btn btn-link" data-target="#show" data-toggle="modal" id="show_user" data-showid="{{$user->id}}">{{$user->name}}</button></td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_user_name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{date('Y/m/d', strtotime($user->dob))}}</td>
                                <td>{{$user->created_at->format('Y/m/d')}}</td>
                                <td><a href="#deleteConfirmModal" class="btn btn-danger userDelete" onclick="deleteData({{$user->id}})"
                                    data-toggle="modal">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <!-- pagination -->
                <ul class="pagination col-md-12 justify-content-center">
                    {{$users->links()}}
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
