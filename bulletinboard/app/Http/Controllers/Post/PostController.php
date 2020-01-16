<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Show post registrarrion form.
     *
     * @return [view] CreatePost
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Display a listing of the Post Detail.
     *
     * @return [view] Post List
     */
    public function index()
    {
        $auth_id = Auth::user()->id;
        $type    = Auth::user()->type;
        session()->forget([
            'searchKeyword',
            'title',
            'desc'
        ]);
        $posts = $this->postService->getPost($auth_id, $type);
        return view('post.postList', compact('posts'));
    }

    /**
     * Search Post Details
     * @param [request]
     * @return [postlist]
     */
    public function search(Request $request)
    {
        $auth_id = Auth::user()->id;
        $type = Auth::user()->type;
        $searchkeyword = $request->search;
        $posts = $this->postService->search($auth_id, $type, $searchkeyword);
        return view('post.postlist', compact('posts'));
    }

    /**
     * Create a new post instance after a valid registration.
     *
     * @param [Request] title and description from user input
     * @return [view] create post confirmation page
     */
    public function createConfirm(Request $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:posts,title',
            'desc' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        return view('post.createConfirm', compact('title', 'desc'));
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  [Request] post details from user input and auth_id
     * @return [view] postlist
     */
    public function store(Request $request)
    {
        $auth_id =  Auth::user()->id;
        $post    =  new Post;
        $post->title = $request->title;
        $post->desc  = $request->desc;
        $posts   =  $this->postService->store($auth_id, $post);
        return redirect()->intended('posts')
            ->withSuccess('Post create successfully.');
    }

    /**
     * Show the form for update post
     *
     * @param [Request] post_id User click post
     * @return [view] update post with post detail
     */
    public function edit($post_id)
    {
        $post_detail = $this->postService->edit($post_id);
        return view('post.edit', ['post_detail' => $post_detail]);
    }

    /**
     * Update Confirm the specified resource in storage.
     *
     * @param  [Request] user input data
     * @param  auth_id
     * @return [view] update confirmation page
     */
    public function editConfirm(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $title = $request->title;
        $desc = $request->desc;
        $status = $request->status;
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:posts,title,' . $post->id,
            'desc' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if (is_null($status)) {
            $status = '0';
        }
        return view('post.editConfirm', compact('title', 'desc', 'status', 'post_id'));
    }

    /**
     * Update Post in storage.
     *
     * @param  [Request] user input data
     * @param  auth_id
     * @return [view] postlist with successfully message
     */
    public function update(Request $request, $post_id)
    {
        $user_id  =  Auth::user()->id;
        $post     =  new Post;
        $post->id     =  $post_id;
        $post->title  =  $request->title;
        $post->desc   =  $request->desc;
        $post->status   =  $request->status;
        $posts    =  $this->postService->update($user_id, $post);
        return redirect()->intended('posts')
            ->withSuccess('Post update successfully.');
    }

    /**
     * Show csv upload form
     *
     */
    public function upload()
    {
        return view('post.upload');
    }

    /**
     * Import
     */
}
