<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use App\Dao\Post\PostsExport;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
        session([
            'search' => $searchkeyword
        ]);
        $posts = $this->postService->search($auth_id, $type, $searchkeyword);
        return view('post.postlist', ['posts'=>$posts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $post   = Post::findOrFail($request->id);
        $title  = $post->title;
        $desc   = $post->description;
        $status = $post->status;
        if ($status == 1) {
            $status = 'Active';
            return response()->json(array('title'=>$title,'desc'=>$desc,'status'=>$status));
        } else {
            $status = 'Inactive';
            return response()->json(array('title'=>$title,'desc'=>$desc,'status'=>$status));
        }

    }

    /**
     * Create a new post instance after a valid registration.
     *
     * @param [Request] title and description from user input
     * @return [view] create post confirmation page
     */
    public function createConfirm(PostRequest $request)
    {
        $title = $request->title;
        $desc = $request->desc;
        $validator = $request->validated();
        session([
            'title' => $title,
            'desc'  => $desc
        ]);
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
        return redirect()->intended('post')
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
        return redirect()->intended('post')
            ->withSuccess('Post update successfully.');
    }

    /**
     * SoftDelete Post
     *
     * @param [request] post_id
     * @return [post]
     */
    public function destory(Request $request)
    {
        $post_id = $request->post_id;
        $auth_id = Auth::user()->id;
        $posts = $this->postService->softDelete($auth_id, $post_id);
        return redirect()->intended('post')
            ->withSuccess('Post delete successfully.');
    }

    /**
     * Export CSV
     */
    public function export()
    {
        $auth_type = Auth::user()->type;
        return Excel::download(new PostsExport, 'posts.xlsx');

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
     * Import csv file to public path
     * @param [Request] import file
     * @return [view] postlist
     */
    public function import(PostRequest $request)
    {
        $auth_id = Auth::user()->id;
        $validator = $request->validated();
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $file->move($auth_id.'/csv' . $filename);
        $filepath = public_path() . '/'.$auth_id .'/csv/' .$filename;
        $import_csv_file = $this->postService->import($auth_id, $filepath);
        return redirect()
            ->intended('post')
            ->withSuccess('CSV file upload successfully.');
    }
}
