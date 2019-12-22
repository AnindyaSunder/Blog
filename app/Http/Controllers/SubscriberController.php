<?php

namespace App\Http\Controllers;
use App\Subscriber;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
    	try
    	{
    		$this->validate($request,[
    		'email' => 'required|email|unique:subscribers',
	    	]);

	    	$subscriber = new Subscriber();
	    	$subscriber->email = $request->email;
	    	$subscriber->save();

	    	Toastr::success('You are Successfully Subscribed','Success');
	    	return redirect()->back();
    	}
    	catch(\Exception $e)
    	{


    		// dd($e);

			Toastr::error($e->getMessage());
	    	return redirect()->back();
    	}
    }
}
