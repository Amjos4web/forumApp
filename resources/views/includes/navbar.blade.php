<nav class="navbar navbar-inverse" style="background: rgba(34, 33, 33, 1.0);">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" id="header" href="{{ url('/') }}">
                    {{ config('app.name', 'My App') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    {{-- <li class="nav-item active">
                        <a href="/">Home</a>
                    </li> --}}
                    {{-- <li>
                        <a href="/about">About HDS Connect</a>
                    </li> --}}
                   
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <form action="/search" method="GET" role="search" style="margin-top: 10px;">
                            {{ csrf_field() }}
                            <input type="text" class="search" name="searchText" placeholder="Search for trends" required>
                            <input type="submit" name="search" value="Search">
                        </form>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                Welcome! {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li><a href="/dashboard">Dashboard</a></li>
                                <li><a href='{{ route('user.edit') }}'>My Profile</a></li>
                                {{-- <li><a href="{{ route('tasks.index') }}">Tasks</a></li> --}}
                                <li><a href="{{ route('feeds.index') }}">News Feed</a></li>
                                <li><a href="/user">Connect with friends</a></li>
                                <li><a href="/chat" target="_blank">Chat Room</a></li>
                                {{-- <li><a href="/feeds">Timeline</a></li> --}}
                                {{-- <li><a href="#">Notifications</a></li> --}}
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>