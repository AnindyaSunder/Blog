@extends('layouts.backend.masterback')

@section('title','Tag')

@push('extra_css')

@endpush


@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ADD NEW TAG
                            <small>With floating label</small>
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('admin.tag.store') }} " method="POST">
                            @csrf
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="tag" class="form-control" name="name" >
                                    <label class="form-label">Tag Name</label>
                                </div>
                            </div>
                            <a href="{{ route('admin.tag.index') }}" class="btn btn-danger m-t-15 waves-effect" style="padding:7px;font-size: 14px;">BACK</a>
                            <button type="submit" class="btn btn-info m-t-15 waves-effect" style="padding:7px;font-size: 14px;">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>   
</div>
@push('extra_js')
    
@endpush


@endsection