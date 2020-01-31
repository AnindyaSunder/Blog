<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthorProfileController extends Controller
{
    public function profile($username)
    {
    	try
    	{
    		$author = User::where('username',$username)->first();
	    	$posts = $author->posts()->approved()->published()->get();
	    	return view('profile',compact('author','posts'));
    	}
    	catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
