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
                <form action="/users" method="POST" class="form-inline">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="text" name="name" class="form-control form-control-md mb-4 mr-3" placeholder="Name">
                        <input type="text" name="email" class="form-control form-control-md mb-4 mr-3" placeholder="Email">
                        @error('email')
                            <label for="validation" class="text-danger">{{ $message }}</label>
                        @enderror
                        <input type="date" name="createfrom" class="form-control form-control-md mb-4 mr-3" placeholder="Created From">
                        <input type="date" name="createto" class="form-control form-control-md mb-4 mr-3" placeholder="Created To">
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
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-name" id="user-name"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p class="userName"></p>
            <p class="userEmail"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<!--User Detail-->

<script type="text/javascript">
    $(document).on('click','#show_user',function(){
        var id=$this.data('showid');
        console.log(id);
        $.post('/showUser',{'_token':$('input[name=_token]').val() ,id:id},function(data){
            $('.modal-name').text('User Detail');
            $('.userName').text(data.name);
            $('.userEmail').text(data.email);
        });
    });
</script>
<!--End User Detail-->
@endsection
