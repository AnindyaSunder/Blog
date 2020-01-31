<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthorDashController extends Controller
{
    public function index()
    {
    	try
    	{
    		$user = Auth::user();
	    	$posts = $user->posts;
	    	$popular_posts = $user->posts()
            	    			->withCount('comments')
            	    			->withCount('favourite_to_users')
            	    			->orderBy('view_count','DESC')
            	    			->orderBy('comments_count')
            	    			->orderBy('favourite_to_users_count')
            	    			->take(5)->get();
	    	$pending_posts = $posts->where('is_approved',false)->count();
	    	$all_views = $posts->sum('view_count');		
	    	return view('author.authorDash',compact('posts','popular_posts','pending_posts','all_views'));
    	}
    	catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
