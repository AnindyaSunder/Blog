@extends('layouts.frontend.master')

@section('title', 'Category_Posts')

@push('extra_css')
    <link href="{{ asset ('public/assets/frontend/css/post_category_all/styles.css')}}" rel="stylesheet">

    <link href="{{ asset ('public/assets/frontend/css/post_category_all/responsive.css')}}" rel="stylesheet">

    <style>
        .slider {
            height: 400px;
            width: 100%;
            background-image: url({{ asset('public/upload/categorySlider/'.$category->image) }});
            background-size: cover;
        }
        .favourite_posts{
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{ $category->name }}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">
                @if ($posts->count() > 0)
                    @foreach ($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100">
                                <div class="single-post post-style-1">

                                    <div class="blog-image"><img src="{{ asset('public/upload/post/'.$post->image) }}"></div>

                                    <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ asset('public/upload/user/'.$post->user->image) }}" alt="Profile Image"></a>

                                    <div class="blog-info">

                                        <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                        <ul class="post-footer">
                                            <li>
                                                @guest
                                                    <a href="javascript:void(0);" onclick="toastr.info('To add Favorite list You have to login first!','Info',{
                                                        closeButton: true,
                                                        progressBar: true,
                                                    })"><i class="ion-heart"></i>{{ $post->favourite_to_users->count() }}</a>
                                                @else
                                                    <a href="#" onclick="document.getElementById('favourite-{{ $post->id }}').submit();"
                                                        class="{{ !Auth::user()->favourite_posts->where('pivot.post_id',$post->id)->count() == 0 ? 'favourite_posts' : '' }}">
                                                        <i class="ion-heart"></i>{{ $post->favourite_to_users->count() }}</a>

                                                    <form id="favourite-{{ $post->id }}" method="POST" action="{{ route('post.favourite',$post->id) }}" style="display: none">
                                                        @csrf
                                                    </form>
                                                @endguest
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a>
                                            </li>
                                        </ul>

                                    </div><!-- blog-info -->
                                </div><!-- single-post -->
                            </div><!-- card -->
                        </div><!-- col-lg-4 col-md-6 -->
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-info">

                                    <h4 class="title">
                                        <b>{{ $post->title }}</b>
                                        <strong>Sorry, No data found!</strong>
                                    </h4>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endif
            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->

   

@push('extra_js')
    
@endpush
    
@endsection