<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
    	return view('admin.settings');
    }
    public function profileUpdate(request $request)
    {
    	//return $request;
    	$user = User::findOrFail(Auth::id());

    	$this->validate($request,[
    		'name'=>'required',
    		'email'=>'required',
    		'about'=>'required',
    		'image'=>'required | mimes:png,jpg,jpeg,gif',

    	]);

    	$data = $request->all();
    	if($user)
    	{

            try
            {
                
                if($request->hasFile('image'))
                {
                    

                    $originalImage = $request->file('image');
                    $thumbnailImage = Image::make($originalImage);
                    $originalPath = public_path().'/upload/user/';
                    $thumbnailImage->resize(500,500);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);

                    if(!$user->image=="")
                    {
                        if(File::exists(public_path('/upload/user/'.$user->image)));
                        {
                            File::delete(public_path('/upload/user/'.$user->image)); 
                        }   
                    }
                }
                else
                {
                    $imagename = $user->image;
                }

                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->image = $imagename;
                $user->about = $data['about'];
                $user->save();

                Toastr::success('The Profile Successfully Updated.', 'Success');
                return redirect()->back();   
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
    public function passwordUpdate(request $request)
    {
    	//return $request;
    	$this->validate($request,[

    		'old_password'=>'required',
    		'password'=>'required | confirmed',

    	]);

    	$hashedPassword = Auth::user()->password;
    	if (Hash::check($request->old_password, $hashedPassword))
    	{
    		if(!Hash::check($request->password, $hashedPassword))
    		{
    			$user = User::findOrFail(Auth::id());
    			$user->password = Hash::make($request->password);
    			$user->save();

    			Toastr::success('Your Password Successfully Changed.', 'Success');
    			Auth::logout();
                return redirect()->back();   
    		}
    		else
    		{

    			Toastr::error('New Password can not be the same as Old Password.', 'Error');
                return redirect()->back();
    		}
    	}
    	else
    	{
    		Toastr::error('Current Password Not Matched!', 'Error');
    		return redirect()->back();
    	}
    }
}
