<?php

namespace App\Http\Controllers\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use app\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AuthorFavouriteContoller extends Controller
{
    public function index()
    {
    	try
    	{
    		$posts = Auth::user()->favourite_posts;
    		return view('author.authorFavourite',compact('posts'));
    	}
    	catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
