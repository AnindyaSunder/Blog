<?php

namespace App\Http\Controllers\Author;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class AuthorCommentController extends Controller
{
    public function index()
    {
    	$posts = Auth::user()->get();
    	return view('author.authorComment',compact('posts'));
    }
    public function destroy($id)
    {
    	try
    	{
    		$comment = Comment::findOrFail($id);
    		if($comment->post->user->id == Auth::id())
    		{
    			$comment->delete();
    			Toastr::success("Comment successfully deleted!","Success");
    		}
    		else
    		{
    			Toastr::error('You are not Authorized to delete this comment.','Access Denied!!');
    		}
    		
    		return redirect()->back();
    	}
    	catch(\Exception $e)
    	{
    		Toastr::error($e->getMessage());
    		return redirect()->back();
    	}
    }
}