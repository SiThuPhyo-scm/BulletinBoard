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
     * Only authenticated users may enter
     *
     * @param PostServiceInterface $postService
     */
    public function __construct(PostServiceInterface $postService)
    {
        $this->middleware('auth');
        $this->postService = $postService;
    }

    /**
     * Show Post list
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $posts = $this->postService->getPost($request);
        return view('post.postList', compact('posts', 'search'));
    }

    /**
     * Search Post Details
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;
        $posts = $this->postService->getPost($request);
        return view('post.postlist', compact('posts', 'search'));
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
        $validator = $request->validated();
        $post = $this->postService->createConfirm($request);
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
        $posts = $this->postService->store($request);
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
        $validator = $request->validated($post_id);
        $post = $this->postService->editConfirm($request);
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
        $posts    =  $this->postService->update($request, $post_id);
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
        session()->forget([
            'search',
            'title',
            'desc',
            'name',
            'email',
            'type',
            'phone',
            'dob',
            'address'
        ]);
        return Excel::download(new PostsExport, 'posts.csv');
    }

    /**
     * Show csv upload form
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        session()->forget([
            'search',
            'title',
            'desc',
            'name',
            'email',
            'type',
            'phone',
            'dob',
            'address'
        ]);
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
        $validator = $request->validated();
        $message = $this->postService->import($request);
        if($message == 1){
            return redirect()
                ->intended('post')
                ->withSuccess('CSV file Upload Successfully');
        } else {
            return redirect()
                ->intended('post')
                ->with('incorrect', 'CSV file Upload Unsucess beacause CSV title has already been taken');
        }
    }
}
