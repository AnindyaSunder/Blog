<aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="{{asset('public/upload/user/'.Auth::user()->image)}}" width="48" height="48" alt="User" />   
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</div>
                    <div class="email">{{ Auth::user()->email }}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ Auth::user()->role_id == 1 ?  route('admin.settings.index') : route('author.settings.index') }}">
                                <i class="material-icons">settings_applications</i>Settings</a>
                            </li>                            
                            <li role="separator" class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="material-icons">input</i>Sign Out
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    @if(Request::is('admin*'))
                        <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="material-icons">dashboard</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/tag*') ? 'active' : '' }}">
                            <a href="{{ route('admin.tag.index') }}">
                                <i class="material-icons">loyalty</i>
                                <span>Tag</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/category*') ? 'active' : '' }}">
                            <a href="{{ route('admin.category.index') }}">
                                <i class="material-icons">category</i>
                                <span>Category</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/post*') ? 'active' : '' }}">
                            <a href="{{ route('admin.post.index') }}">
                                <i class="material-icons">library_books</i>
                                <span>Post</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/pending/post') ? 'active' : '' }}">
                            <a href="{{ route('admin.post.pending') }}">
                                <i class="material-icons">new_releases</i>
                                <span>Pending Post</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/favourite') ? 'active' : '' }}">
                            <a href="{{ route('admin.favourite.index') }}">
                                <i class="material-icons">favorite</i>
                                <span>Favourite Post</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/comments') ? 'active' : '' }}">
                            <a href="{{ route('admin.comment.index') }}">
                                <i class="material-icons">mode_comment</i>
                                <span>Comments</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/sbuscriber') ? 'active' : '' }}">
                            <a href="{{ route('admin.sbuscriber.index') }}">
                                <i class="material-icons">subscriptions</i>
                                <span>Sbuscribers</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('admin/authors') ? 'active' : '' }}">
                            <a href="{{ route('admin.author.index') }}">
                                <i class="material-icons">supervisor_account</i>
                                <span>Authors</span>
                            </a>
                        </li>

                        <li class="header">System</li>
                        <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">
                            <a href="{{ route('admin.settings.index') }}">
                                <i class="material-icons">settings_applications</i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="material-icons">input</i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>  
                    @endif

                    @if(Request::is('author*'))
                        <li class="{{ Request::is('author/dashboard') ? 'active' : '' }}">
                            <a href="{{ route('author.dashboard') }}">
                                <i class="material-icons">dashboard</i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('author/post*') ? 'active' : '' }}">
                            <a href="{{ route('author.post.index') }}">
                                <i class="material-icons">library_books</i>
                                <span>Post</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('author/favourite') ? 'active' : '' }}">
                            <a href="{{ route('author.favourite.index') }}">
                                <i class="material-icons">favorite</i>
                                <span>Favourite Post</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('author/comments') ? 'active' : '' }}">
                            <a href="{{ route('author.comment.index') }}">
                                <i class="material-icons">mode_comment</i>
                                <span>Comments</span>
                            </a>
                        </li>
                        <li class="header">System</li>
                        <li class="{{ Request::is('author/settings') ? 'active' : '' }}">
                            <a href="{{ route('author.settings.index') }}">
                                <i class="material-icons">settings_applications</i>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                <i class="material-icons">input</i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endif
                    
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; {{date('Y')}} <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                </div>
                
            </div>
            <!-- #Footer -->
        </aside>