<div class="nav navbar-nav menu_nav justify-content-end">
    <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle single_dropdown" id="dropdownMenuButtonOne" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-expanded="false">
            <svg width="32" height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>
            @if (Auth::check() && Auth::user()->profile_image)
            <img src="{{Auth::user()->profile_src}}" alt="profile image" width="32" height="32">
            @else
            <svg width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
            </svg>
            @endif
        </a>
        <div class="dropdown-menu drop-down-menu-left p-0 drop-width text-14" aria-labelledby="dropdownMenuButtonOne">
            @if(!Auth::check())
                <a class="dropdown-item" href="{{ url('signup') }}">{{trans('messages.sign_up.sign_up')}}</a>
                <a class="dropdown-item" href="{{ url('login') }}">{{trans('messages.header.login')}}</a>
            @else
                <a class="vbg-default-hover border-0  font-weight-700 list-group-item vbg-default-hover border-0" href="{{ route('notifications') }}" aria-label="dashboard">{{trans('Notifications')}}
                    <span class="float-right badge badge-success">{{ $notificationCount }}</span>
                </a>
                <a class="vbg-default-hover border-0  font-weight-700 list-group-item vbg-default-hover border-0" href="{{ url('dashboard') }}" aria-label="dashboard">{{trans('messages.header.dashboard')}}</a>
                <a class="font-weight-700 list-group-item vbg-default-hover border-0 " href="{{ url('users/profile') }}" aria-label="profile">{{trans('messages.utility.profile')}}</a>
                <a class="font-weight-700 list-group-item vbg-default-hover border-0 " href="{{ url('logout') }}" aria-label="logout">{{trans('messages.header.logout')}}</a>
            @endif
            <hr>
            @if(Request::segment(1) != 'help')
            <a class="dropdown-item" href="{{ url('property/create') }}">{{trans('messages.header.list_space')}}</a>
            @endif
            @guest
            <a class="dropdown-item" href="{{ url('property/create') }}">{{trans('Become a Host')}}</a>
            @endguest
        </div>
    </div>
</div>
