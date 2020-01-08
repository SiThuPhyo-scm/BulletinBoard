<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Auth;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    private $postService;

    public function __construct(PostServiceInterface $post)
    {
        $this->postService = $post;
    }
    /**
     * Show post registrarrion form.
     */
    public function createform()
    {
        return view('post.create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auth_id = Auth::user()->id;
        $type = Auth::user()->type;
        session()->forget([
            'searchKeyword',
            'title',
            'desc',
        ]);

        return view('post.postList');
    }
    /**
     * Show the form for create a new Post
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
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
        session([
            'title' => $title,
            'desc' => $desc,
        ]);
        return view('post.createConfirm', compact('title', 'desc'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth_id = Auth::user()->id;
        $post = new Post;
        $post->title = $request->title;
        $post->desc = $request->desc;
        $posts = $this->postService->store($auth_id, $post);
        return view('post.postList', compact('posts'))->withSuccess('Post create successfully.');
    }
}
