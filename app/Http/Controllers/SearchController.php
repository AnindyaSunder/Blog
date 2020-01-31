<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	try
    	{
    		$query = $request->input('query');
	    	$posts = Post::where('title','LIKE',"%$query%")->approved()->published()->get();
	    	return view('search',compact('posts','query'));
    	}
    	catch(\Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
}
