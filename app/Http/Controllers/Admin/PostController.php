<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Tag;
use App\Post;
use App\User;
use App\Subscriber;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.post.postIndex',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.postCreate',compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'required | mimes:jpg,jpeg,png,PNG,bmp,gif',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $data = $request->all();
        //dd($data);
        if($data)
        {
            try
            {
                $imagename = "";
                if($request->hasFile('image'))
                {
                    

                    $originalImage = $request->file('image');
                    $thumbnailImage = Image::make($originalImage);
                    $originalPath = public_path().'/upload/post/';
                    $thumbnailImage->resize(1600,1066);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);
                }

                $post = new Post();
                $post->user_id = Auth::id();
                $post->title = $data['title'];
                $post->slug = str_slug($data['title']);
                $post->image = $imagename;
                $post->body = $data['body'];
                if(isset($data['status']))
                {
                    $post->status = 1;
                }
                else
                {
                   $post->status = 0; 
                }
                $post->is_approved = 1;
                $post->save();

                $post->categories()->attach($data['categories']);
                $post->tags()->attach($data['tags']);

                $subscribers = Subscriber::all();
                foreach ($subscribers as $subscriber) 
                {
                  Notification::route('mail', $subscriber->email)
                    ->notify(new NewPostNotify($post));
                }

                Toastr::success('The Post Successfully Saved.', 'Success');
                return redirect()->route('admin.post.index');
            }
            catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //return $post;
        return view('admin.post.postShow',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.postEdit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title' => 'required',
            'image' => 'mimes:jpg,jpeg,png,PNG,bmp,gif',
            'categories' => 'required',
            'tags' => 'required',
            'body' => 'required',
        ]);
        $data = $request->all();
        //dd($data);
        if($data)
        {
            try
            {
                
                if($request->hasFile('image'))
                {
                    
                    $originalImage = $request->file('image');
                    $thumbnailImage = Image::make($originalImage);
                    $originalPath = public_path().'/upload/post/';
                    $thumbnailImage->resize(1600,1066);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);

                    if(!$post->image=="")
                    {
                        if(File::exists(public_path('/upload/post/'.$post->image)));
                        {
                            File::delete(public_path('/upload/post/'.$post->image)); 
                        }   
                    }
                }
                else
                {
                    $post->image = $imagename;
                }

                
                $post->user_id = Auth::id();
                $post->title = $data['title'];
                $post->slug = str_slug($data['title']);
                $post->image = $imagename;
                $post->body = $data['body'];
                if(isset($data['status']))
                {
                    $post->status = 1;
                }
                else
                {
                   $post->status = 0; 
                }
                $post->is_approved = 1;
                $post->save();

                $post->categories()->sync($data['categories']);
                $post->tags()->sync($data['tags']);

                Toastr::success('The Post Successfully Updated.', 'Success');
                return redirect()->route('admin.post.index');
            }
            catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
        }
        else
        {
            return redirect()->back();

        }
    }
    public function pending()
    {
        $posts = Post::where('is_approved',false)->get();
        return view('admin.post.postPending',compact('posts'));
    }
    public function approval($id)
    {
        $post = Post::find($id);
        if ($post->is_approved == false)
        {
         $post->is_approved = true;
         $post->save();

         $post->user->notify(new AuthorPostApproved($post));

         $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) 
            {
              Notification::route('mail', $subscriber->email)
                ->notify(new NewPostNotify($post));
            }
            
         Toastr::success('This Post Successfully Approved','success'); 
        }
        else
        {
            Toastr::info('This Post is already Approved','info');
        }
        return redirect()->route('admin.post.pending'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //return $post;
        if($post)
        {
           try
          {
            if(File::exists(public_path('/upload/post/'.$post->image)))
            {
              File::delete(public_path('/upload/post/'.$post->image));
               
            }
            $post->categories()->detach(); 
            $post->tags()->detach(); 
            $post->delete();
            Toastr::success('The Post Successfully Deleted.', 'Success');
            return redirect()->route('admin.post.index');
          }
          catch(\Exception $e)
          {
                Toastr::error($e->getMessage());
                return redirect()->back();
          }
        }
        else
        {
          return redirect()->back();

        }
    }
}
