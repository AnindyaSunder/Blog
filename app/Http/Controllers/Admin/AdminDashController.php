<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;

class AdminDashController extends Controller
{
    public function index()
    {
    	try
    	{
            $posts = Post::all();
            $popular_posts = Post::withCount('comments')
                                ->withCount('favourite_to_users')
                                ->orderBy('view_count','desc')
                                ->orderBy('comments_count','desc')
                                ->orderBy('favourite_to_users_count','desc')
                                ->take(5)->get();
            $pending_posts = Post::where('is_approved',false)->count();
            $total_views = Post::sum('view_count');
            $all_authors = User::where('role_id',2)->count();
            $new_authors_today = User::where('role_id',2)
                                    ->whereDate('created_at',Carbon::today())->count();
            $active_authors = User::where('role_id',2)
                                ->withCount('posts')                               
                                ->withCount('comments')                               
                                ->withCount('favourite_posts')
                                ->orderBy('posts_count','desc')                               
                                ->orderBy('comments_count','desc')                               
                                ->orderBy('favourite_posts_count','desc')
                                ->take(10)->get();
            $category_count = Category::all()->count();                                                       
            $tag_count = Tag::all()->count();                                                       
    		return view('admin.adminDash',compact('posts','popular_posts','pending_posts','total_views','all_authors','new_authors_today','active_authors','category_count','tag_count'));
    	}
    	catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
