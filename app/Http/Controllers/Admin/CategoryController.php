<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.category.catIndex',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.catCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $this->validate($request,[
            'name' => 'required | unique:categories',
            'image' => 'required | mimes:jpg,jpeg,png,PNG,bmp,gif',
        ]);
        $data = $request->all();
        if($data)
        {
            try
            {
                $imagename = "";
                if($request->hasFile('image'))
                {
                    

                    $originalImage = $request->file('image');
                    $thumbnailImage = Image::make($originalImage);
                    $originalPath = public_path().'/upload/category/';
                    $thumbnailImage->resize(1600,479);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);


                    $originalPath = public_path().'/upload/categorySlider/';
                    $thumbnailImage->resize(500,333);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);
                }

                $category = new Category();
                $category->name = $data['name'];
                $category->slug = str_slug($data['name']);
                $category->image = $imagename;
                $category->save();
                Toastr::success('The Category Successfully Saved.', 'Success');
                return redirect()->route('admin.category.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //return $id;
        $edit = Category::Find($id);
        return view('admin.category.catEdit',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Category::Find($id);
        //return $update;
        $this->validate($request,[
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png,PNG,bmp,gif',
        ]);
       $data = $request->all();
        if($update)
          {
            try
              {
                
                if($request->hasFile('image'))
                  {
                    

                    $originalImage = $request->file('image');
                    $thumbnailImage = Image::make($originalImage);
                    $originalPath = public_path().'/upload/category/';
                    $thumbnailImage->resize(1600,479);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);

                    if(!$update->image=="")
                    {
                      if(File::exists(public_path('/upload/category/'.$update->image)));
                      {
                        File::delete(public_path('/upload/category/'.$update->image)); 
                      }   
                    }
                    

                    $originalPath = public_path().'/upload/categorySlider/';
                    $thumbnailImage->resize(500,333);
                    $imagename = time().$originalImage->getClientOriginalName();
                    $thumbnailImage->save($originalPath.$imagename);

                    if(!$update->image=="")
                    {
                      if(File::exists(public_path('/upload/categorySlider/'.$update->image)));
                      {
                        File::delete(public_path('/upload/categorySlider/'.$update->image)); 
                      }   
                    }    
                  }
                else
                  {
                    $imagename = $update->image;
                  }

                $update->name = $data['name'];
                $update->slug = str_slug($data['name']);
                $update->image = $imagename;
                $update->save();
                Toastr::success('The Category Successfully Updated.', 'Success');
                return redirect()->route('admin.category.index');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Category::find($id);
        //return $delete;
        if($delete)
        {
          try
          {
            if(File::exists(public_path('/upload/category/'.$delete->image)))
            {
              File::delete(public_path('/upload/category/'.$delete->image));
              File::delete(public_path('/upload/categorySlider/'.$delete->image)); 
            } 
            $delete->delete();
            Toastr::success('The Category Successfully Deleted.', 'Success');
            return redirect()->route('admin.category.index');
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
