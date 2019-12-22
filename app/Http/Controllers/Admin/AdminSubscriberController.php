<?php

namespace App\Http\Controllers\Admin;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
class AdminSubscriberController extends Controller
{
    public function index()
    {
    	$subscribers = Subscriber::latest()->get();
    	return view('admin.subscriber.subscriberIndex',compact('subscribers'));
    }
    public function destroy($id)
    {
    	$sbuscriber = Subscriber::findOrFail($id);
    	$sbuscriber->delete();
    	Toastr::success('Subscriber Successfully Deleted :)','Success');
    	return redirect()->back();
    }
}
