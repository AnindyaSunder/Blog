<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request,$post)
    {
    	$this->validate($request,[
    		'comment' => 'required',
    	]);

    	try
    	{
    		$comment = new Comment();
    		$comment->user_id = Auth::id();
    		$comment->post_id = $post;
    		$comment->comment = $request->comment;
    		$comment->save();

    		Toastr::success('Comment Successfully Published :)','Success');
    		return redirect()->back();

    	}
    	catch(\Exception $e)
    	{
    		Toastr::error($e->getMessage());
    		return redirect()->back();
    	}
    }
}
