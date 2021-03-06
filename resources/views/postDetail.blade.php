@extends('layouts.frontend.master')

@section('title')
    {{ $post->title }}
@endsection

@push('extra_css')
    <link href="{{ asset ('public/assets/frontend/css/single_post/styles.css')}}" rel="stylesheet">

    <link href="{{ asset ('public/assets/frontend/css/single_post/responsive.css')}}" rel="stylesheet">
    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{ asset('public/upload/post/'.$post->image) }});
            background-size: cover;
        }
        .favourite_posts{
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="header-bg">
        
        </div>
    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="{{ route('author.profile',$post->user->username) }}"><img src="{{ asset('public/upload/user/'.$post->user->image) }}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{ $post->user->name }}</b></a>
                                    <h6 class="date">on {{ $post->created_at->diffForHumans() }}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b>{{ $post->title }}</b></a></h3>

                            <div class="para">
                                {!! $post->body !!}
                            </div>

                            <ul class="tags">
                                @foreach ($post->tags as $tag)

                                    <li><a href="{{ route('tag.posts',$tag->slug) }}">{{ $tag->name }}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
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
                                <li><a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>


                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT USER</b></h4>
                            <p>{{  $post->user->about }}</p>
                        </div>

                        <div class="tag-area">

                            <h4 class="title"><b>CATEGORIES</b></h4>
                            <ul>
                                @foreach ($post->categories as $category)

                                    <li><a href="{{ route('category.posts',$category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @foreach ($randomposts as $randompost)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ asset('public/upload/post/'.$randompost->image) }}"></div>

                                <a class="avatar" href="{{ route('author.profile',$randompost->user->username) }}"><img src="{{ asset('public/upload/user/'.$randompost->user->image) }}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details',$randompost->slug) }}"><b>{{ $randompost->title }}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('To add Favorite list You have to login first!','Info',{
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i>{{ $randompost->favourite_to_users->count() }}</a>
                                            @else
                                                <a href="#" onclick="document.getElementById('favourite-{{ $randompost->id }}').submit();"
                                                    class="{{ !Auth::user()->favourite_posts->where('pivot.post_id',$randompost->id)->count() == 0 ? 'favourite_posts' : '' }}">
                                                    <i class="ion-heart"></i>{{ $randompost->favourite_to_users->count() }}</a>

                                                <form id="favourite-{{ $randompost->id }}" method="POST" action="{{ route('post.favourite',$randompost->id) }}" style="display: none">
                                                    @csrf
                                                </form>
                                            @endguest
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-chatbubble"></i>{{ $randompost->comments->count() }}</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-eye"></i>{{ $randompost->view_count }}</a>
                                        </li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
                

            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                            <p>For post a new comment,You need to login first! <a href="{{ route('login') }}" class="btn btn-secondary float-right">Login</a></p>
                        @else
                            <form method="POST" action="{{ route('comment.store',$post->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <textarea name="comment" rows="2" class="text-area-messge form-control"
                                            placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                    </div><!-- col-sm-12 -->
                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                    </div><!-- col-sm-12 -->

                                </div><!-- row -->
                            </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{ $post->comments->count() }})</b></h4>

                    @if ( $post->comments->count() > 0 )
                        
                        @foreach ($post->comments as $comment)
                        
                            <div class="commnets-area ">

                                <div class="comment">

                                    <div class="post-info">

                                        <div class="left-area">
                                            <a class="avatar" href="{{ route('author.profile',$comment->user->username) }}"><img src="{{ asset('public/upload/user/'.$comment->user->image) }}" alt="Profile Image"></a>
                                        </div>

                                        <div class="middle-area">
                                            <a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
                                            <h6 class="date">{{ $comment->created_at->diffForHumans() }}</h6>
                                        </div>
                                    </div><!-- post-info -->

                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div><!-- commnets-area -->
                        @endforeach

                    @else
                        <div class="commnets-area ">

                            <div class="comment">
                                <p class="text-center">No comment yet.Be the first.</p>
                            </div>   
                        </div><!-- commnets-area -->
                    @endif
                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>

@push('extra_js')
    
@endpush
    
@endsection