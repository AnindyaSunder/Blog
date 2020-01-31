<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class AuthorShowController extends Controller
{
    public function index()
    {
    	try
        {
            $authors = User::authors()
                ->withCount('posts')
                ->withCount('favourite_posts')
                ->withCount('comments')
                ->get();
            return view('admin.authors',compact('authors'));
        }
        catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
    public function destroy($id)
    {
    	try
        {
            $author = User::findOrFail($id);
            $author->delete();
            Toastr::success('Author Successfully Deleted.', 'Success');
            return redirect()->back();
        }
        catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}
