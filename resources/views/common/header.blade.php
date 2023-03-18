<!--================ Header Menu Area start =================-->
<?php $lang = Session::get('language'); ?>
@php
$notificationCount = DB::table('notifications')->where('user_id',auth()->id())->count();
@endphp
<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">
<header class="header_area  animated fadeIn">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light align-items-center">
            <div class="container-fluid container-fluid-90">
                <a class="navbar-brand logo_h" aria-label="logo" href="{{ url('/') }}"><img src="{{ $logo ?? '' }}" alt="logo" style="max-height:60px"></a>

                <div class="d-lg-none">
                    <div class="d-flex justify-content-end align-items-center">
                        @auth
                        <a href="{{ route('notifications') }}" class="px-3 position-relative">
                            <span class="badge badge-info rounded-circle position-absolute right">{{ $notificationCount > 9 ? "9+": $notificationCount }}</span>
                            <svg width="24" height="24" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                            </svg>
                        </a>
                        @endauth
                        @include('includes.header-usr-btn-mobile')
                    </div>
                </div>

                @if (Route::is('home'))
                <div class="w-100 px-5 py-3 d-flex justify-content-center">
                    <form id="front-search-form" method="post" action="{{url('search')}}"> @csrf
                        @include('includes.header-search-form')
                    </form>
                </div>
                @endif


                <div class="d-none d-lg-block">
                    <div class="d-flex justify-content-end align-items-center">
                        @auth
                        <a href="{{ route('notifications') }}" class="px-3 position-relative">
                            <span class="badge badge-info rounded-circle position-absolute right">{{ $notificationCount > 9 ? "9+": $notificationCount }}</span>
                            <svg width="24" height="24" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                            </svg>
                        </a>
                        @endauth
                        @include('includes.header-usr-btn', ['notificationCount' => $notificationCount])
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- Modal Window -->
<div class="modal left fade" id="left_modal" tabindex="-1" role="dialog" aria-labelledby="left_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0 secondary-bg">
                @if(Auth::check())
                <div class="row justify-content-center">
                    <div>
                        <img src="{{Auth::user()->profile_src}}" class="head_avatar" alt="{{Auth::user()->first_name}}">
                    </div>

                    <div>
                        <p class="text-white mt-4"> {{Auth::user()->first_name}}</p>
                    </div>
                </div>
                @endif

                <button type="button" class="close text-28" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <ul class="mobile-side">
                    @if(Auth::check())
                    <li><a href="{{ url('dashboard') }}"><i class="fa fa-tachometer-alt mr-3"></i>{{trans('messages.header.dashboard')}}</a></li>
                    <li><a href="{{ url('inbox') }}" class="d-flex justify-content-between align-items-center">
                            <div><i class="fas fa-inbox mr-3"></i>{{trans('messages.header.inbox')}}</div>
                            @php
                            $count = getInboxUnreadCount();
                            @endphp
                            @if ($count)
                            <span class="badge badge-danger rounded-circle mr-2 text-12">{{$count}}</span>
                            @endif
                        </a></li>
                    <li><a href="{{ url('properties') }}"><i class="far fa-list-alt mr-3"></i>{{trans('messages.header.your_listing')}}</a></li>
                    <li><a href="{{ url('activities') }}"><i class="far fa-list-alt mr-3"></i>{{trans('messages.header.activities')}}</a></li>

                    <a data-toggle="collapse" href="#collapse-bookings-mob" role="button" aria-expanded="false" aria-controls="collapse-bookings-mob">
                        <li><i class="fas fa-bookmark mr-3"></i>{{trans('messages.booking_my.booking')}}</li>
                    </a>

                    <div class="collapse" id="collapse-bookings-mob">
                        <ul class="ml-4">
                            <li><a href="{{ url('my-bookings') }}?category=property" class="text-14">{{trans('messages.property.property')}}</a></li>
                            <li><a href="{{ url('my-bookings') }}?category=activity" class="text-14">{{trans('messages.activity.activity')}}</a></li>
                        </ul>
                    </div>

                    <li><a href="{{ url('trips/active') }}"><i class="fa fa-suitcase mr-3"></i>
                            {{trans('messages.header.your_trip')}}</a></li>
                    <li><a href="{{ url('user/favourite') }}"><i class="fas fa-heart mr-3"></i>
                            {{trans('messages.users_dashboard.favourite')}}</a></li>
                    <li><a href="{{ url('users/payout-list') }}"><i class="far fa-credit-card mr-3"></i>
                            {{trans('messages.sidenav.payouts')}}</a></li>
                    <li><a href="{{ url('users/transaction-history') }}"><i class="fas fa-money-check-alt mr-3 text-14"></i>
                            {{trans('messages.account_transaction.transaction')}}</a></li>
                    <li><a href="{{ url('users/profile') }}"><i class="far fa-user-circle mr-3"></i>{{trans('messages.utility.profile')}}</a></li>
                    <a data-toggle="collapse" href="#collapse-review-menu-mob" role="button" aria-expanded="false" aria-controls="collapse-review-menu-mob">
                        <li><i class="fas fa-user-edit mr-3"></i>{{trans('messages.sidenav.reviews')}}</li>
                    </a>

                    <div class="collapse" id="collapse-review-menu-mob">
                        <ul class="ml-4">
                            <li><a href="{{ url('users/reviews') }}" class="text-14">{{trans('messages.reviews.reviews_about_you')}}</a></li>
                            <li><a href="{{ url('users/reviews_by_you') }}" class="text-14">{{trans('messages.reviews.reviews_by_you')}}</a></li>
                        </ul>
                    </div>
                    <li><a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt mr-3"></i>{{trans('messages.header.logout')}}</a></li>
                    @else
                    <li><a href="{{ url('signup') }}"><i class="fas fa-stream mr-3"></i>{{trans('messages.sign_up.sign_up')}}</a></li>
                    <li><a href="{{ url('login') }}"><i class="far fa-list-alt mr-3"></i>{{trans('messages.header.login')}}</a></li>
                    @endif

                    @if(Request::segment(1) != 'help')
                    <a href="{{ url('property/create') }}">
                        <button class="btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            {{trans('messages.header.list_space')}}
                        </button>
                    </a>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!--================Header Menu Area =================-->
