@extends('layouts.backend.masterback')

@section('title','Post_Edit')

@push('extra_css')
<!-- Bootstrap Select Css -->
    <link href=" {{ asset('public/assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }} " rel="stylesheet">

@endpush


@section('content')
    <div class="container-fluid">
        <form action="{{ route('admin.post.update',$post->id) }} " method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT POST
                                <small>With floating label</small>
                            </h2>
                        </div>
                        <div class="body">
                                
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="title" class="form-control" name="title" value="{{ $post->title }}">
                                    <label class="form-label">Post Title</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image">
                                <img src="{{ asset('public/upload/post/'.$post->image) }}" alt="Image" width="50px" height="50px">
                            </div>
                            <div class="form-group">
                                <input type="checkbox" id="publish" class="filled-in" name="status" value="1" {{   $post->status == true ? 'checked' : '' }}>
                                <label for="publish">Publish</label>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CATEGORIES & TAGS
                                <small>With floating label</small>
                            </h2>
                        </div>
                        <div class="body">
                           <div class="form-group form-float">
                                    <div class="form-line {{$errors->has('categories') ? 'focused error' : '' }}">
                                        <label for="category">Select Category</label>
                                        <select name="categories[]" id="SelectCategory" class="form-control show-tick" data-live-search="true" multiple>
                                            @foreach ($categories as $category)
                                                <option @foreach ($post->categories as $postcategory)
                                                            {{ $postcategory->id == $category->id ? 'selected' : '' }}
                                                        @endforeach
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group form-float">
                                    <div class="form-line {{$errors->has('tags') ? 'focused error' : ''}}">
                                        <label for="tag">Select Tag</label>
                                        <select name="tags[]" id="SelectTag" class="form-control show-tick" data-live-search="true" multiple>
                                            @foreach ($tags as $tag)
                                                <option @foreach ($post->tags as $postTag)
                                                            {{ $postTag->id == $tag->id ? 'selected' : '' }}
                                                        @endforeach
                                                value="{{ $tag->id }}">{{ $tag->name }}</option>
                                            @endforeach    
                                        </select>
                                    </div>
                                </div>
                                <a href="{{ route('admin.post.index') }}" class="btn btn-danger m-t-15 waves-effect" style="padding:7px;font-size: 14px;">BACK</a>
                                <button type="submit" class="btn btn-info m-t-15 waves-effect" style="padding:7px;font-size: 14px;">SUBMIT</button> 
                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                BODY
                                <small>With floating label</small>
                            </h2>
                        </div>
                        <div class="body">
                            <textarea name="body" id="tinymce">
                                {{ $post->body }}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>  
        </form>     
</div>
@push('extra_js')
 <!-- Select Plugin Js -->
    <script src="{{ asset('public/assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
  <!-- TinyMCE -->
    <script src="{{ asset('public/assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{ asset('public/assets/backend/plugins/tinymce') }}';
        });
    </script>

@endpush


@endsection