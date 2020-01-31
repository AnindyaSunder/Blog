<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Session;

class PostDetailController extends Controller
{
	public function index()
	{
		$posts = Post::latest()->approved()->published()->paginate(12);
		return view('postCategoryAll',compact('posts'));
	}
    public function details($slug)
    {
    	try
    	{
    		$post = Post::where('slug',$slug)->approved()->published()->first();
	    	$blogKey = 'blog_'.$post->id;
	    	if(!Session::has($blogKey))
	    	{
	    		$post->increment('view_count');
	    		Session::put($blogKey,1);
	    	}

	    	$randomposts = Post::approved()->published()->take(3)->inRandomOrder()->get();
	    	return view('postDetail',compact('post','randomposts'));
    	}
    	catch(\Exception $e)
        {
            Toastr::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function postByCategory($slug)
    {
    	$category = Category::where('slug',$slug)->first();
    	$posts = $category->posts()->approved()->published()->get();
    	return view('categoryPost',compact('category','posts'));
    }
    public function postByTag($slug)
    {
    	$tag = Tag::where('slug',$slug)->first();
    	$posts = $tag->posts()->approved()->published()->get();
    	return view('tagPost',compact('tag','posts'));
    }
}
