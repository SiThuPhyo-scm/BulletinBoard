@extends('layouts.app')

@section('title','PostList')
@section('content')
<div id="postList">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>Post List</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <form action="/posts/search" method="POST" class="form-inline">
                @csrf
                <div class="form-group mb-2">
                    <input type="text" name="search" value="{{session('searchKeyword')}}" class="form-control form-control-lg mb-4 mr-3" placeholder="Search...">
                    <button type="submit" class="btn btn-primary btn-lg mb-4 ml-4">Search</button>
                    <a href="/post/create" class="btn btn-primary btn-lg mb-4 ml-4">Add</a>
                    <a href="/csv/upload" class="btn btn-primary btn-lg mb-4 ml-4">Upload</a>
                    <a href="/download" class="btn btn-primary btn-lg mb-4 ml-4">Download</a>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <table class="table table-bordered">
                <thead class="thead-light text-nowrap">
                    <th>Post Title</th>
                    <th>Post Description</th>
                    <th>Posted User</th>
                    <th>Posted Date</th>
                    <th></th>
                    <th></th>
                </thead>

            </table>
        </div>
            <!-- pagination -->
            <ul class="pagination col-md-12 justify-content-center">

            </ul>

    </div>
        <!-- Post Detail Modal -->
        <div class="modal fade" id="show" role="dialog">
        <div class="modal-dialog" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="post-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="postTitle"></p>
                <p class="postDesc"></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
</div>

@endsection
