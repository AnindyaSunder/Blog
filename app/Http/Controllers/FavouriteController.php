<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    public function add($post)
    {
    	try
    	{
    		$user = Auth::user();
	    	$isFavourite = $user->favourite_posts()->where('post_id',$post)->count();

	    	if($isFavourite == 0)
	    	{
	    		$user->favourite_posts()->attach($post);
	    		Toastr::success('Post Successfully added to your Favoutite list.', 'Success');
                return redirect()->back(); 
	    	}
	    	else
	    	{
	    		$user->favourite_posts()->detach($post);
	    		Toastr::warning('This Post removed to your Favoutite list.', 'Success');
                return redirect()->back();	
	    	}
    	}
    	catch(\Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }
}
