<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class AdminCommentController extends Controller
{
    public function index()
    {
    	$comments = Comment::latest()->get();
    	return view('admin.adminComment',compact('comments'));
    }
    public function destroy($id)
    {
    	try
    	{
    		Comment::findOrFail($id)->delete();
    		Toastr::success("Comment successfully deleted!","Success");
    		return redirect()->back();
    	}
    	catch(\Exception $e)
    	{
    		Toastr::error($e->getMessage());
    		return redirect()->back();
    	}
    }
}
