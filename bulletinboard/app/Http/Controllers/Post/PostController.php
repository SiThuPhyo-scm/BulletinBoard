<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class PostController extends Controller
{
    /**
     * Show post registrarrion form.
     */
    public function createform()
    {
        return view('post.create');
    }
    /**
     * Show the form for create a new Post
     *
     * @return
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
            'desc'  => $desc
        ]);
        return view('Post.createConfirm', compact('title', 'desc'));
    }
}
