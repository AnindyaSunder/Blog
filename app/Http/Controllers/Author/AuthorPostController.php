<?php

namespace App\Http\Controllers\Author;

use App\Category;
use App\Tag;
use App\Post;
use App\User;
use App\Notifications\NewAuthorNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
class AuthorPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.author_post.ApostIndex',compact('posts'));
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
        return view('author.author_post.ApostCreate',compact('categories','tags'));
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
                $post->is_approved = 0;
                $post->save();

                $post->categories()->attach($data['categories']);
                $post->tags()->attach($data['tags']);

                $users = User::where('role_id','1')->get();
                Notification::send($users, new NewAuthorNotify($post));


                Toastr::success('The Post Successfully Saved.', 'Success');
                return redirect()->route('author.post.index');
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
        if($post->user_id != Auth::id())
        {
            Toastr::error('Unauthorized access denied!','Error');
            return redirect()->back();
        }
        
        return view('author.author_post.ApostShow',compact('post'));    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id())
        {
            Toastr::error('Unauthorized access denied!','Error');
            return redirect()->back();
        }

        $categories = Category::all();
        $tags = Tag::all();
        return view('author.author_post.ApostEdit',compact('post','categories','tags'));
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
        if($post->user_id != Auth::id())
        {
            Toastr::error('Unauthorized access denied!','Error');
            return redirect()->back();
        }

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
                $post->is_approved = 0;
                $post->save();

                $post->categories()->sync($data['categories']);
                $post->tags()->sync($data['tags']);

                Toastr::success('The Post Successfully Updated.', 'Success');
                return redirect()->route('author.post.index');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //return $post;
        if($post->user_id != Auth::id())
        {
            Toastr::error('Unauthorized access denied!','Error');
            return redirect()->back();
        }
        
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
            return redirect()->route('author.post.index');
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
