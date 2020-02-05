@extends('layouts.app')

@section('title','User List')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>User List</h3>
        </div>
        <div class="card-body">
            <form action="/user" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <input type="text" name="name" class="form-control form-control-md mb-4" value="{{ $search->name }}" placeholder="Name">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <input type="text" name="email" class="form-control form-control-md mb-4" value="{{ $search->email }}" placeholder="Email">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <input type="text" name="startdate" value="{{ $search->startdate }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" class="form-control mb-4" placeholder="Created From">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <input type="text" name="enddate" value="{{ $search->enddate }}" onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" class="form-control mb-4" placeholder="Created To">
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-md mb-4">Search</button>
                            <a href="/user/create" class="btn btn-primary btn-md mb-4 ml-4">Add</a>
                        </div>
                    </div>
                </div>
            </form>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                    @php
                        Session::forget('success');
                    @endphp
                </div>
            @endif
            <div class="row table-scroll">
                <table class="table table-striped table-bordered col-12 col-sm-12 col-md-12">
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
                                <td>{{$user->createuser->name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{date('Y/m/d', strtotime($user->dob))}}</td>
                                <td>{{$user->created_at->format('Y/m/d')}}</td>
                                <td><a href="#deleteConfirmModal" class="btn btn-danger userDelete" onclick="deleteUser({{$user->id}})" data-toggle="modal">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <!-- pagination -->
                <ul class="pagination col-md-12 justify-content-center mt-2">
                @if(!empty($search))
                    {{$users->appends(request()->except('page'))->links()}}
                @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Show Post Detail with modal -->
<div class="modal fade" id="show" role="dialog">
    <div class="modal-dialog col-8" role="document" >
      <div class="card modal-content">
        <div class="card-header modal-header">
            <h3 class="modal-name" id="show_user"></h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="card-body modal-body">
            <div class="row text-center">
                <label class="col-12 userProfile"></label>
            </div>
            <div class="row">
                <label class="col-4">Name</label>
                <label class="col-8 userName"></label>
            </div>
            <div class="row">
                <label class="col-4">Email</label>
                <label class="col-8 userEmail"></label>
            </div>
            <div class="row">
                <label class="col-4">Phone</label>
                <label class="col-8 userPhone"></label>
            </div>
            <div class="row">
                <label class="col-4">Date of Birth</label>
                <label class="col-8 userDob"></label>
            </div>
            <div class="row">
                <label class="col-4">Address</label>
                <label class="col-8 userAddress"></label>
            </div>
            <div class="row">
                <label class="col-4">Created AT</label>
                <label class="col-8 userCreated"></label>
            </div>
            <div class="row">
                <label class="col-4">Created User</label>
                <label class="col-8 userCreateduser"></label>
            </div>
            <div class="row">
                <label class="col-4">Last Updated AT</label>
                <label class="col-8 userUpdated"></label>
            </div>
            <div class="row">
                <label class="col-4">Updated User</label>
                <label class="col-8 userUpdateduser"></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<!-- Post delete confirm Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" class="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure want to delete this User?</p>
                    <input type="hidden" id="user_id" name="user_id" class="userID" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

