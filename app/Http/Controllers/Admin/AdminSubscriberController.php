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
    	try
        {
            $subscribers = Subscriber::latest()->get();
            return view('admin.subscriber.subscriberIndex',compact('subscribers'));
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
            $sbuscriber = Subscriber::findOrFail($id);
            $sbuscriber->delete();
            Toastr::success('Subscriber Successfully Deleted :)','Success');
            return redirect()->back();
        }
        catch(\Exception $e)
            {
                Toastr::error($e->getMessage());
                return redirect()->back();
            }
    }
}

