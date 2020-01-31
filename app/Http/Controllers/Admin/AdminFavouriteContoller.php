<?php

namespace App\Http\Controllers\Admin;

use app\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

class AdminFavouriteContoller extends Controller
{
    public function index()
    {
    	try
    	{
    		$posts = Auth::user()->favourite_posts;
    		return view('admin.adminFavourite',compact('posts'));
    	}

    	catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
