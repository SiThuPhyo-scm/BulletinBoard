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
        if ($type == '0') {
            $posts = Post::orderBy('updated_at', 'DESC')->paginate(5);
        } else {
            $posts = Post::where('create_user_id', $auth_id)
                ->orderBy('updated_at', 'DESC')
                ->paginate(5);
        }
        return view('post.postList', ['posts' => $posts]);
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
        return view('post.createConfirm', ['title' => $title], ['desc' => $desc]);
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
        $insert_post = new Post([
            'title' => $request->title,
            'description' => $request->desc,
            'create_user_id' => $auth_id,
            'updated_user_id' => $auth_id,
        ]);
        $insert_post->save();
        $posts = Post::where('create_user_id', $auth_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(5);
        return redirect()->intended('posts');
    }
    /**
     * Show the form for update post
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post_detail = Post::find($post_id);
        return view('post.edit', ['post_detail' => $post_detail]);
    }
    /**
     * Update Confirm the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editConfirm(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $title = $request->title;
        $desc = $request->desc;
        $status = $request->status;
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:posts,title' . $post->id,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        $user_id  =  Auth::user()->id;
        $post->id = $post_id;
        $update_post = Post::find($post->id);
        $update_post->title            =  $post->title;
        $update_post->description      =  $post->desc;
        $update_post->status           =  $post->status;
        $update_post->updated_user_id  =  $user_id;
        $update_post->updated_at       =  now();
        $update_post->save();
        $posts = Post::where('post_id', $post_id)
            ->orderBy('updated_at', 'DESC')
            ->paginate(5);
        return redirect()->intended('posts');
    }
}
