@extends('layouts.backend.masterback')

@section('title','Edit_Category')

@push('extra_css')

@endpush


@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT CATEGORY
                            <small>With floating label</small>
                        </h2>
                    </div>
                    <div class="body">
                        <form action=" {{ route('admin.category.update',$edit->id) }} " method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="tag" class="form-control" name="name" value="{{ $edit->name }}">
                                    <label class="form-label">Category Name</label>
                                </div>
                                <div class="form-group">
                                    <div class="" style="margin-top: 15px">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image">
                                        <img src="{{ asset('public/upload/category/'.$edit->image) }}" alt="Image" width="50px" height="50px">
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-danger m-t-15 waves-effect" style="padding:7px;font-size: 14px;">BACK</a>
                            <button type="submit" class="btn btn-info m-t-15 waves-effect" style="padding:7px;font-size: 14px;">UPDATE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>   
</div>
@push('extra_js')
    
@endpush


@endsection