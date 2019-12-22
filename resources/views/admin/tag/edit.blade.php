@extends('layouts.backend.masterback')

@section('title','Edit_Tag')

@push('extra_css')

@endpush


@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT TAG
                            <small>With floating label</small>
                        </h2>
                    </div>
                    <div class="body">
                        <form action=" {{ route('admin.tag.update',$tag->id) }} " method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="tag" class="form-control" name="name" value="{{ $tag->name }}">
                                    <label class="form-label">Tag Name</label>
                                </div>
                            </div>
                            <a href="{{ route('admin.tag.index') }}" class="btn btn-danger m-t-15 waves-effect" style="padding:7px;font-size: 14px;">BACK</a>
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