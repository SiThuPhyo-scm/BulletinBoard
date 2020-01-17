@extends('layouts.app')

@section('title','User List')

@section('script')
<script src="{{ asset('js/custom.js') }}"></script>
@endsection

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>User List</h3>
        </div>
        <div class="card-body">
            <form action="/user/search" method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <input type="text" name="name" class="form-control form-control-md mb-4" placeholder="Name">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-3">
                        <input type="text" name="email" class="form-control form-control-md mb-4" placeholder="Email">
                        @error('email')
                            <label for="validation" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <input type="date" name="createfrom" class="form-control form-control-md mb-4" placeholder="Created From">
                    </div>
                    <div class="col-sm-6 col-md-3 col-lg-2">
                        <input type="date" name="createto" class="form-control form-control-md mb-4" placeholder="Created To">
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
                <table class="table table-bordered col-12 col-sm-12 col-md-12">
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
                <ul class="pagination col-md-12 justify-content-center mt-2">
                    {{$users->links()}}
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Show Post Detail with modal -->
<div class="modal fade" id="show" role="dialog">
    <div class="modal-dialog" role="document" >
      <div class="card modal-content">
        <div class="card-header modal-header">
            <h3 class="modal-name" id="show_user"></h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="card-body modal-body">
            <div class="row">
                <label class="col-3">Name</label>
                <label class="col-9 userName"></label>
            </div>
            <div class="row">
                <label class="col-3">Email</label>
                <label class="col-9 userEmail"></label>
            </div>
            <div class="row">
                <label class="col-3">Phone</label>
                <label class="col-9 userPhone"></label>
            </div>
            <div class="row">
                <label class="col-3">Address</label>
                <label class="col-9 userAddress"></label>
            </div>
            <div class="row">
                <label class="col-3">Date of Birth</label>
                <label class="col-9 userDob"></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<script>
$(document).on('click','#show_user',function() {
    var id=$(this).data('showid');
    console.log(id);
    $.post('/showUser',{'_token':$('input[name=_token]').val() ,id:id},function(data){
        $('.modal-name').text('User Detail');
        $('.userName').text(data.name);
        $('.userEmail').text(data.email);
        $('.userPhone').text(data.phone);
        $('.userAddress').text(data.address);
        $('.userDob').text(data.dob);
    });
});
</script>
@endsection
