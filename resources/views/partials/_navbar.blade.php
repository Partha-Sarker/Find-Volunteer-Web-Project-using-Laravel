<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Find Volunteer') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        @php
            $route = Request::route()->getName();
        @endphp
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav my-auto">
                <li class="nav-item {{$route == "home" ? "active" : ""}}">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item {{$route == "organization.index" ? "active" : ""}}">
                    <a class="nav-link" href="{{route('organization.index')}}">Organizations</a>
                </li>
                <li class="nav-item {{$route == "event.index" ? "active" : ""}}">
                    <a class="nav-link" href="{{route('event.index')}}">Events</a>
                </li>
                <li class="nav-item {{$route == "volunteer.index" ? "active" : ""}}">
                    <a class="nav-link" href="{{route('volunteer.index')}}">Volunteers</a>
                </li>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="/register">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    @php
                        $current_id = Auth::user();
                        $authRole = Auth::user()->role;
                        $cur_vol_id=-5;
                        $cur_org_id=-5;
                        if($authRole == "volunteer") {
                            $cur_vol_id = Auth::user()->Volunteer->id;
                            // dd($volunteer->id);
                        }
                        else if($authRole == "organization") {
                            $cur_org_id = Auth::user()->Organization->id;
                            // dd($organization->id);
                        }
                    @endphp
                    <li class="nav-item {{($route == "volunteer.show" && $cur_vol_id==$volunteer->id) || ($route == "organization.show" && $cur_org_id==$organization->id) ? "active" : ""}}">
                        <a class="nav-link" href="{{Auth::user()->role=='volunteer' ? route('volunteer.show', Auth::user()->Volunteer->id):route('organization.show', Auth::user()->Organization->id)}}">My Profile</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Welcome 
                            {{Auth::user()->role=='volunteer' ? Auth::user()->Volunteer->first_name:Auth::user()->Organization->name}} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
{{-- <div class="row mb-5"></div> --}}
<br>
<br>
<br>