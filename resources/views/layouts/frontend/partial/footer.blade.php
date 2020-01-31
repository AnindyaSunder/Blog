<footer>

        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">

                        <b><p class="copyright">{{ config('app.name') }} @ {{date('Y')}}. All rights reserved.</p></b>
                        <p class="copyright">Designed by <a href="https://colorlib.com" target="_blank">Colorlib</a>   &<br> Developed by <a href="https://github.com/AnindyaSunder" target="_blank">Anindya Sunder</a></p>
                        <ul class="icons">
                            <li><a target="_blank" href="https://www.facebook.com"><i class="ion-social-facebook-outline"></i></a></li>
                            <li><a target="_blank" href="https://twitter.com"><i class="ion-social-twitter-outline"></i></a></li>
                            <li><a target="_blank" href="https://www.instagram.com"><i class="ion-social-instagram-outline"></i></a></li>
                            <li><a target="_blank" href="https://vimeo.com"><i class="ion-social-vimeo-outline"></i></a></li>
                            <li><a target="_blank" href="https://www.linkedin.com"><i class="ion-social-linkedin-outline"></i></a></li>
                        </ul>

                    </div><!-- footer-section -->
                </div><!-- col-lg-4 col-md-6 -->

                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <h4 class="title"><b>CATAGORIES</b></h4>
                        <ul>
                            @foreach ($categories as $category)

                                <li>
                                    <a href="{{ route('category.posts',$category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endforeach   
                        </ul>
                    </div><!-- footer-section -->
                </div><!-- col-lg-4 col-md-6 -->

                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">

                        <h4 class="title"><b>SUBSCRIBE</b></h4>
                        <div class="input-area">
                            <form action="{{ route('sbuscriber.store') }}" method="POST">
                                @csrf
                                <input class="email-input" name="email" type="email" placeholder="Enter your email">
                                <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                            </form>
                        </div>

                    </div><!-- footer-section -->
                </div><!-- col-lg-4 col-md-6 -->

            </div><!-- row -->
        </div><!-- container -->
    </footer>