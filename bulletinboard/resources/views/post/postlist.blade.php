@extends('layouts.app')

@section('title','PostList')

@section('script')
<script src="{{ asset('js/custom.js') }}"></script>
@endsection

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="col-md-3">
                <h3>Post List</h3>
            </div>
        </div>
        <div class="card-body">
            <form action="/post/search" method="POST" class="form-inline">
                @csrf
                <div class="col-md-12">
                    <div class="row form-group text-center">
                        <div class="col-sm-12 col-md-5 col-lg-5 text-md-right">
                            <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-md mb-4" placeholder="Search...">
                        </div>
                        <div class="col-md-7 col-lg-7">
                            <div class="form-group text-center">
                                <button type="submit" class="form-group btn btn-primary btn-md mb-4">Search</button>
                                <a href="/post/create" class="form-group btn btn-primary btn-md mb-4 ml-4">Add</a>
                                <a href="/csv/upload" class="form-group btn btn-primary btn-md mb-4 ml-4">Upload</a>
                                <a href="/download" class="form-group btn btn-primary btn-md mb-4 ml-4">Download</a>
                            </div>
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
                <table class="table table-bordered">
                    <thead class="text-nowrap">
                        <th>Post Title</th>
                        <th>Post Description</th>
                        <th>Posted User</th>
                        <th>Posted Date</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($posts as $key => $post)
                            <tr>
                                <td><button class="btn btn-link" data-target="#show" data-toggle="modal" id="show_post" data-show-id="{{$post->id}}">{{$post->title}}</button></td>
                                <td>{{$post->description}}</td>
                                <td>{{$post->user->name}}</td>
                                <td>{{$post->created_at->format('Y/m/d')}}</td>
                                <td><a href="/post/{{$post->id}}" class="btn btn-primary">Edit</a></td>
                                <td><a href="#deleteConfirmModal" class="btn btn-danger postDelete" onclick="deleteData({{$post->id}})" data-toggle="modal">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <!-- pagination -->
                <ul class="pagination col-md-12 justify-content-center mt-2">
                    {{$posts->links()}}
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Post Detail Modal -->
<div class="modal fade" id="show" role="dialog">
    <div class="modal-dialog" role="document" >
        <div class="card modal-content">
            <div class="card-header modal-header">
                <h3 class="modal-title" id="post-title"></h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="card-body modal-body">
                <div class="row">
                    <label class="col-3">Title</label>
                    <label class="col-9 postTitle"></label>
                </div>
                <div class="row">
                    <label class="col-3">Description</label>
                    <label class="col-9 postDesc"></label>
                </div>
                <div class="row">
                    <label class="col-3">Status</label>
                    <label class="col-9 postStatus"></label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- User delete confirm Modal -->
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
                    <p>Are you sure want to delete this post?</p>
                    <input type="hidden" id="post_id" name="post_id" class="postID" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End User delete confirm Modal -->
<script>
$(document).on('click','#show_post',function(){
    var id=$(this).data('show-id');
    console.log(id);
    $.post('/showPost',{'_token':$('input[name=_token]').val() ,id:id},function(data){
        $('.modal-title').text('Post Detail');
        $('.postTitle').text(data.title);
        $('.postDesc').text(data.desc);
        $('.postStatus').text(data.status);
    });
});
</script>
<!--User Delete-->
<script type="text/javascript">
    function deleteData(id)
    {
        var id = id;
        var url = "/post/"+id;
        $(".deleteForm").attr('action', url);
        $(".postID").attr('value',id);
    }
</script>
<!--End User Delete-->

@endsection
