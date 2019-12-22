@extends('layouts.backend.masterback')

@section('title','Post_Show')

@push('extra_css')

@endpush


@section('content')
    <div class="container-fluid">
        <a href="{{ route('author.post.index') }}" class="btn btn-danger waves-effect">BACK</a>
        @if ($post->is_approved == true)
            <button type="button" class="btn btn-success pull-right disabled">
                <i class="material-icons">done</i>
                <span>Approved</span>
            </button>
        @else
            <button type="button" class="btn btn-warning pull-right disabled">
                <i class="material-icons">new_releases</i>
                <span>Wait Approvel</span>
            </button>
        @endif
        <br><br>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ $post->title }}
                            <small>Posted By <strong><a href="">{{ $post->user->name }} on {{ $post->created_at->toFormattedDateString() }}</a></strong></small>
                        </h2>
                    </div>
                    <div class="body">
                            {!! $post->body !!}  
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2>
                            CATEGORIES
                            
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($post->categories as $category)
                            <span class="label bg-cyan">{{ $category->name }}</span>
                        @endforeach
                       
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-green">
                        <h2>
                           TAGS
                            
                        </h2>
                    </div>
                    <div class="body">
                        @foreach ($post->tags as $tag)
                            <span class="label bg-green">{{ $tag->name }}</span>
                        @endforeach  
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-amber">
                        <h2>
                           FEATURED IMAGE
                            
                        </h2>
                    </div>
                    <div class="body">
                         <img src="{{ asset('public/upload/post/'.$post->image) }}" class="img-thumbnail" alt="Image">
                    </div>
                </div>
            </div>
        </div>   
    </div>
@push('extra_js')
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