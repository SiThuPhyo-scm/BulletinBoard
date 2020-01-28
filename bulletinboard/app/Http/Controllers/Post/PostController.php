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
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

/**
 * SystemName: BulletinBoard
 * ModuleName: Post
 */
class PostController extends Controller
{
    /**
     * Associated with the Service
     *
     */
    private $postService;

    /**
     * Create a new Controller instance.
     *
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Show Post list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        session()->forget([
            'searchKeyword',
            'title',
            'desc'
        ]);
        $posts = $this->postService->getPost($auth_id = Auth::user()->id, $type = Auth::user()->type);
        return view('post.postList', compact('posts'));
    }

    /**
     * Search Post Details
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        session([
            'searchkeyword' => $request->search
        ]);
        $posts = $this->postService->search($auth_id = Auth::user()->id, $type = Auth::user()->type, $searchkeyword = $request->search);
        return view('post.postlist', compact('posts'));
    }

    /**
     * Post List with modal
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $post = $this->postService->show($post_id=$request->id);
        return response()->json($post);
    }

    /**
     * Show post create form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Create a new post instance after a valid registration.
     *
     * @param PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function createConfirm(PostRequest $request)
    {
        $post    =  new Post;
        $post->title = $request->title;
        $post->desc  = $request->desc;
        $validator = $request->validated();
        session([
            'title' => $request->title,
            'desc'  => $request->desc
        ]);
        return view('post.createConfirm', compact('post'));
    }

    /**
     * Store Post Detail
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post    =  new Post;
        $post->title = $request->title;
        $post->desc  = $request->desc;
        $posts   =  $this->postService->store($auth_id =  Auth::user()->id, $post);
        return redirect()->intended('post')
            ->withSuccess('Post create successfully.');
    }

    /**
     * Show the form for update post
     *
     * @param $post_id
     * @return \Illuminate\Http\Response
     */
    public function edit($post_id)
    {
        $post_detail = $this->postService->edit($post_id);
        return view('post.edit', compact('post_detail'));
    }

    /**
     * Update post after validation
     *
     * @param  PostRequest $request
     * @param  $post_id
     * @return \Illuminate\Http\Response
     */
    public function editConfirm(PostRequest $request, $post_id)
    {
        $post = new Post;
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->status = $request->status;
        $validator = $request->validated($post_id);
        if (is_null($post->status)) {
            $post->status = '0';
        }
        return view('post.editConfirm', compact('post','post_id'));
    }

    /**
     * Update Post in database.
     *
     * @param  Request $request
     * @param  $post_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_id)
    {
        $post     =  new Post;
        $post->id     =  $post_id;
        $post->title  =  $request->title;
        $post->desc   =  $request->desc;
        $post->status   =  $request->status;
        $posts    =  $this->postService->update($user_id = Auth::user()->id, $post);
        return redirect()->intended('post')
            ->withSuccess('Post update successfully.');
    }

    /**
     * Delete Post
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destory(Request $request)
    {
        $posts = $this->postService->softDelete($auth_id = Auth::user()->id, $post_id = $request->post_id);
        return redirect()->intended('post')
            ->withSuccess('Post delete successfully.');
    }

    /**
     * Export CSV
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        return Excel::download(new PostsExport, 'posts.csv');
    }

    /**
     * Show csv upload form
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('post.upload');
    }

    /**
     * Import csv file to public path
     *
     * @param FileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function import(FileRequest $request)
    {
        $auth_id = Auth::user()->id;
        $validator = $request->validated();
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $file->move( 'csv/' . $auth_id , $filename);
        $filepath = public_path() . '/csv/' . '/'.$auth_id .'/' .$filename;
        $message = $this->postService->import($auth_id, $filepath);
        if($message == 1){
            return redirect()
                ->intended('post')
                ->withSuccess('CSV file Upload Successfully');
        } else {
            return redirect()
                ->intended('post')
                ->with('incorrect', 'CSV file Upload Unsucess beacause CSV title already exit');
        }
    }
}
