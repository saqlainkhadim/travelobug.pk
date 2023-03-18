@extends('template', ['title' => $result->name . " - Travelobug.pk"])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/glyphicon.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('public/js/ninja/ninja-slider.min.css') }}" />

    <style>
        .vbtn-outline-success:hover {
            background: var(--scheme-color) !important;
        }

        .btn-outline-danger:hover {
            background: #dc3545 !important;
        }
    </style>
@endpush
@section('main')

    <input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">

    <div class="container-fluid container-fluid-90">
        <div class="row" id="mainDiv">
            <div class="col-lg-8 col-xl-9">
                <div id="sideDiv" style="margin-top: 86px">

                    {{-- PHOTOS STARTS --}}
                    <!--popup slider-->
                    <div class="d-none" id="showSlider">
                        <div id="ninja-slider">
                            <div class="slider-inner">
                                <ul>
                                    @foreach ($activity_photos as $row_photos)
                                        <li>
                                            <a class="ns-img" href="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" aria-label="photo"></a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
                            </div>
                        </div>
                    </div>
                    @if (count($activity_photos) > 0)

                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                        @foreach ($activity_photos as $key => $row_photos)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" class="d-block w-100" onclick="lightbox({{ $key }})" alt="Image">
                            </div>
                        @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                        </div>

                        <div class="d-flex">
                            @foreach ($activity_photos as $key => $row_photos)
                                @if ($key == 0)
                                @elseif($key <= 4)
                                    @if ($key == 4)
                                        <div class="position-relative p-2 gal-img">
                                            <div class="view-all h-110px">
                                                <img src="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $key }})" />
                                                <span class="position-center cursor-pointer" onclick="lightbox({{ $i }})">{{ trans('messages.property_single.view_all') }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="py-2 gal-img">
                                            <div class="h-110px">
                                                <img src="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $key }})" />
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @php break; @endphp
                                @endif
                            @endforeach
                        </div>

                <hr>
            @endif
                    <!--popup slider end-->
                    {{-- @if (count($activity_photos) > 0)
                        <div class="row mt-4">
                            <div class="col-md-12 col-sm-12 pl-3 pr-3">
                                <div class="row">
                                    @php $i=0 @endphp

                                    @foreach ($activity_photos as $row_photos)
                                        @if ($i == 0)
                                            <div class="col-md-12 col-sm-12 mb-2 mt-2 p-2">
                                                <div class="slider-image-container" onclick="lightbox({{ $i }})" style="background-image:url({{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }});"></div>
                                            </div>
                                        @elseif($i <= 4)
                                            @if ($i == 4)
                                                <div class="position-relative p-2">
                                                    <div class="view-all gal-img h-110px">
                                                        <img src="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $i }})" />
                                                        <span class="position-center cursor-pointer" onclick="lightbox({{ $i }})">{{ trans('messages.property_single.view_all') }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="p-2">
                                                    <div class="h-110px gal-img">
                                                        <img src="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $i }})" />
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @php break; @endphp
                                        @endif
                                        @php $i++ @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif --}}

                    {{-- PHOTOS ENDS --}}
                    <div class="d-flex rounded-4 mt-4 border p-4">
                        <div class="text-center">
                            <a href="{{ url('users/show/' . $result->host_id) }}">
                                <img alt="User Profile Image" class="img-fluid rounded-circle img-90x90 mr-4" src="{{ $result->user->profile_src }}" title="{{ $result->user->first_name }}">
                            </a>
                        </div>

                        <div class="ml-2">
                            <h3 class="text-20 mt-4"><strong>{{ $result->name }}</strong></h3>
                            <span class="text-14 gray-text">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $result->address->city }}@if($result->address->city != ''),@endif
                                {{ $result->address->state }}@if ($result->address->state != ''),@endif
                                @if ($result->address->countries) {{ $result->address->countries->name }} @endif
                            </span>
                            @if ($result->avg_rating)
                                <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf('%.1f', $result->avg_rating) }} ({{ $result->guest_review }})</p>
                            @endif
                        </div>
                        <div class="ml-auto">
                            @auth
                                <a class="btn btn-sm book_mark_change" data-status="{{ $result->book_mark }}" data-id="{{ $result->id }}" style="color:{{ $result->book_mark == true ? 'var(--scheme-color)' : '' }}; ">
                                    <span style="font-size: 22px;">
                                        <i class="fas fa-heart pl-5"></i>
                                    </span></a>
                            @endauth
                        </div>
                    </div>

                </div>

                <div class="row justify-content-center desktop mt-5 rounded border pb-5" id="listMargin">
                    <div class="col-md-12 mt-3 pl-4 pr-4">
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2><strong>{{ trans('messages.property_single.about_list') }}</strong> </h2>
                                    <p class="mt-4 text-justify">{{ $result->description->summary }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-3 col-sm-3">
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18">
                                                {{ trans('messages.activity_single.what_youll_do') }}</h2>
                                            <p>{{ $result->what_you_do }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-9 col-sm-9">
                                    <p class="mt-4 text-justify">{{ $result->description->description ?? '' }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-3 col-sm-3">
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18">
                                                {{ trans('messages.activity_single.whats_included') }}</h2>
                                            <p>{{ $result->what_include }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-9 col-sm-9">
                                    <div class="row">
                                        @php $i = 1 @endphp

                                        @php $count = round(count($amenities)/2) @endphp
                                        @foreach ($amenities as $all_amenities)
                                            @if ($i < 6)
                                                <div class="col-md-6 col-sm-6">
                                                    <div>
                                                        @if(file_exists(public_path('images/symbols/' . $all_amenities->symbol)))
                                                        <img src="{{ asset('public/images/symbols/' . $all_amenities->symbol) }}" width="20">
                                                        @else
                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                        @endif
                                                        @if ($all_amenities->status == null)
                                                            <del>
                                                        @endif
                                                        {{ $all_amenities->title }}
                                                        @if ($all_amenities->status == null)
                                                            </del>
                                                        @endif
                                                    </div>
                                                </div>
                                                @php $i++ @endphp
                                            @endif
                                        @endforeach

                                        @if (count($amenities) > 6)
                                        <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                            <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                    data-toggle="modal" data-target="#exampleModalCenter">
                                                + {{ trans('messages.property_single.more') }}
                                            </button>
                                        </div>
                                        @endif

                                        <div class="row">
                                            <!-- Modal -->
                                            <div class="modal fade z-index-high mt-5" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="w-100 pt-3">
                                                                <h5 class="modal-title text-20 font-weight-700 text-center"
                                                                    id="exampleModalLongTitle">
                                                                    {{ trans('messages.activity_single.whats_included') }}</h5>
                                                            </div>

                                                            <div>
                                                                <button type="button" class="close text-28 filter-cancel mr-2"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="modal-body pb-5">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        @php $i = 1 @endphp
                                                                        @foreach ($amenities as $all_amenities)
                                                                            @if ($i > 6)
                                                                                <div class="col-md-6 col-sm-6 mt-3">
                                                                                    <div>
                                                                                        @if(file_exists(public_path('images/symbols/' . $all_amenities->symbol)))
                                                                                        <img src="{{ asset('public/images/symbols/' . $all_amenities->symbol) }}" width="20">
                                                                                        @else
                                                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                                                        @endif
                                                                                        @if ($all_amenities->status == null)
                                                                                            <del>
                                                                                        @endif
                                                                                        {{ $all_amenities->title }}
                                                                                        @if ($all_amenities->status == null)
                                                                                            </del>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            @php $i++ @endphp
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>

                            <hr>

                            {{-- PREVIOUS PHOTO PLACEMENT --}}
                        </div>

                        <!--Start Reviews-->
                        @if (!$result->reviews)
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2><strong>{{ trans('messages.reviews.no_reviews_yet') }}</strong></h2>
                                    </div>

                                    @if ($result->user->reviews->count())
                                        <div class="col-md-12">
                                            <p>{{ trans_choice('messages.reviews.review_other_properties', $result->user->guest_review, ['count' => $result->user->guest_review]) }}</p>
                                            <p class="mt-5 mb-4 text-center">
                                                <a href="{{ url('users/show/' . $result->user->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">{{ trans('messages.reviews.view_other_reviews') }}</a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div>
                                                <h2 class="text-20"><strong> {{ trans_choice('messages.reviews.review', $result->guest_review) }}</strong></h2>
                                            </div>

                                            <div class="ml-4">
                                                <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf('%.1f', $result->avg_rating) }} ({{ $result->guest_review }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="font-weight-700 text-16">{{ trans('messages.property_single.summary') }}</h3>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mt-3 rounded border p-4 pt-3 pb-3">
                                            <div class="row justify-content-between">
                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.accuracy') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->accuracy_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.location') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->location_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->location_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4 class="text-truncate">{{ trans('messages.reviews.communication') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->communication_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->communication_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.checkin') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->checkin_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.cleanliness') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->cleanliness_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.value') }}</h4>
                                                        </div>

                                                        <div>
                                                            <ul>
                                                                <li>
                                                                    <progress max="5" value="{{ $result->value_avg_rating }}">
                                                                        <div class="progress-bar">
                                                                            <span></span>
                                                                        </div>
                                                                    </progress>
                                                                    <span> {{ sprintf('%.1f', $result->value_avg_rating) }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="row">
                                    @foreach ($result->reviews as $row_review)
                                        @if ($row_review->reviewer == 'guest')
                                            <div class="col-12 mt-4 mb-2">
                                                <div class="d-flex">
                                                    <div class="">
                                                        <div class="media-photo-badge text-center">
                                                            <a href="{{ url('users/show/' . $row_review->user->id) }}">
                                                                <img alt="{{ $row_review->user->first_name }}" class="" src="{{ $row_review->user->profile_src }}" title="{{ $row_review->user->first_name }}">
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="ml-2 pt-2">
                                                        <a href="{{ url('users/show/' . $row_review->user->id) }}">
                                                            <h2 class="text-16 font-weight-700">{{ $row_review->user->full_name }}</h2>
                                                        </a>
                                                        <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="background text-15">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($row_review->rating >= $i)
                                                            <i class="fa fa-star secondary-text-color"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="mt-2 pr-4 text-justify">{{ $row_review->message }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-4">
                                @if ($result->user->reviews->count() - $result->reviews->count())
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mt-2 text-center">
                                                <a target="blank" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" href="{{ url('users/show/' . $result->user->id) }}">
                                                    <span>{{ trans('messages.reviews.view_other_reviews') }}</span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <hr>
                        <!--End Reviews-->
                        <div class="mt-5">
                            <div class="col-md-12">
                                <div class="clearfix"></div>
                                <h2><strong>{{ trans('messages.property_single.about_host') }}</strong></h2>
                                <div class="d-flex mt-4">
                                    <div class="">
                                        <div class="media-photo-badge text-center">
                                            <a href="{{ url('users/show/' . $result->host_id) }}">
                                                <img alt="{{ $result->user->first_name }}" class="" src="{{ $result->user->profile_src }}" title="{{ $result->user->first_name }}">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="ml-2 pt-3">
                                        <a href="{{ url('users/show/' . $result->host_id) }}">
                                            <h2 class="text-16 font-weight-700 mb-0">{{ $result->user->full_name }}</h2>
                                        </a>
                                        <p class="small mb-0">{{ trans('messages.users_show.member_since') }} {{ date('F Y', strtotime($result->user->created_at)) }}</p>
                                        @if ($result->user->is_verified && $result->user->verified_at)
                                        <small class="mb-0 d-inline-block">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-shield-shaded mb-1" viewBox="0 0 16 16" style="color:var(--scheme-color)">
                                                <path fill-rule="evenodd" d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067v13.866zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                            </svg>
                                            <strong style="color:var(--scheme-color)">Verified</strong>
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xl-3 mb-4 mt-4">
                <div id="sticky-anchor" class="d-none d-md-block"></div>
                <div class="card p-4" style="margin-top: 86px">
                    <div id="booking-price" class="panel panel-default">
                        <div class="" id="booking-banner" class="">
                            <div class="secondary-bg rounded">
                                <div class="col-lg-12">
                                    <div class="row justify-content-between p-3">
                                        <div class="text-white">
                                            {!! moneyFormat($symbol, numberFormat($result->price->price, 2)) !!}
                                        </div>

                                        <div class="text-14 text-white">
                                            <div id="per_night" class="per-night">
                                                {{ trans('messages.activity_single.per_person') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <form accept-charset="UTF-8" method="post" action="{{ url('payments/book/' . $activity_id . "/?category=activity") }}" id="booking_form">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12 single-border border-r-10 p-4">
                                        <div class="row p-2" id="daterange-btn">
                                            <div class="col-6 p-0">
                                                <label>{{ trans('messages.property_single.check_in') }}</label>
                                                <div class="mr-2">
                                                    <input class="form-control" id="startDate" name="checkin" value="{{ $checkin ? $checkin : onlyFormat(date('d-m-Y')) }}" placeholder="dd-mm-yyyy" type="text" required>
                                                </div>
                                            </div>
                                            <input type="hidden" id="activity_id" value="{{ $activity_id }}">
                                            <input type="hidden" id="room_blocked_dates" value="">
                                            <input type="hidden" id="calendar_available_price" value="">
                                            <input type="hidden" id="room_available_price" value="">
                                            <input type="hidden" id="price_tooltip" value="">
                                            <input type="hidden" id="url_checkin" value="{{ $checkin }}">
                                            <input type="hidden" id="url_checkout" value="{{ $checkout }}">
                                            <input type="hidden" id="url_guests" value="{{ $guests }}">
                                            <input type="hidden" name="booking_type" id="booking_type" value="{{ $result->booking_type }}">

                                            <div class="col-6 p-0">
                                                <label>{{ trans('messages.property_single.check_out') }}</label>
                                                <div class="ml-2">
                                                    <input class="form-control" id="endDate" name="checkout" value="{{ $checkout ? $checkout : onlyFormat(date('d-m-Y', time() + 86400)) }}" placeholder="dd-mm-yyyy" type="text" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12 p-0">
                                                <div class="ml-2 mr-2">
                                                    <label>{{ trans('messages.property_single.guest') }}</label>
                                                    <div class="">
                                                        <select id="number_of_guests" class="form-control" name="number_of_guests">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}" <?= $guests == $i ? 'selected' : '' ?>>{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="book_it" class="mt-4">
                                    <div class="js-subtotal-container booking-subtotal panel-padding-fit">
                                        <div id="loader" class="display-off single-load">
                                            <img src="{{ URL::to('/') }}/public/front/img/green-loader.gif" alt="loader">
                                        </div>
                                        <div class="table-responsive price-table-scroll">
                                            <table class="table-bordered price_table table" id="booking_table">
                                                <tbody>
                                                    <div id="append_date"></div>
                                                    <tr>
                                                        <td class="w-50 pl-4">
                                                            <span id="total_person_count" value="">0</span>
                                                            {{ trans('messages.activity_single.person') }},
                                                            <span id="total_day_count" value="">0</span>
                                                            {{ trans('messages.activity_single.day') }}
                                                        </td>
                                                        <td class="pl-4 text-right"><span id="total_person_price" value=""> 0 </span>
                                                            <span id="custom_price" class="fa fa-info-circle secondary-text-color" data-html="true" data-toggle="tooltip" data-placement="top" title=""></span>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="pl-4">
                                                            {{ trans('messages.property_single.service_fee') }}
                                                        </td>
                                                        <td class="pl-4 text-right"><span id="service_fee" value=""> 0 </span></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="pl-4">
                                                            Discount
                                                        </td>
                                                        <td class="pl-4 text-right"><span id="discount" value="">0 </span></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="pl-4">{{ trans('messages.property_single.total') }}</td>
                                                        <td class="pl-4 text-right"><span id="total" value=""> 0 </span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="book_it_disabled" class="d-none text-center">
                                        <p id="book_it_disabled_message" class="icon-rausch">
                                            {{ trans('messages.property_single.date_not_available') }}
                                        </p>
                                        <a href="{{ URL::to('/') }}/search?location={{ $result->address->city }}" class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                            {{ trans('messages.property_single.view_other_list') }}
                                        </a>
                                    </div>

                                    <div id="minimum_disabled" class="d-none text-center">
                                        <p class="icon-rausch text-danger">
                                            {{ trans('messages.property_single.you_have_book') }} <span id="minimum_disabled_message"></span>
                                            {{ trans('messages.property_single.night_dates') }}
                                        </p>
                                        <a href="{{ URL::to('/') }}/search?location={{ $result->address->city }}" class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                            {{ trans('messages.property_single.view_other_list') }}
                                        </a>
                                    </div>

                                    @if ($result->host_id == @Auth::guard('users')->user()->id)
                                    <div class="alert alert-warning text-center">
                                        You can not book your own listing.
                                    </div>
                                    @else
                                    @if (strtolower($result->status) !== strtolower('Unlisted') && $result->approved)
                                    <div class="book_btn col-md-12 text-center">
                                        <button type="submit" class="btn vbtn-outline-success text-14 font-weight-700 mt-3 pl-5 pr-5 pt-3 pb-3" id="save_btn">
                                            <i class="spinner fa fa-spinner fa-spin d-none"></i>
                                            @if($result->booking_type != 'instant')
                                            <span>
                                                {{ trans('messages.property_single.request_book') }}
                                            </span>
                                            @endif
                                            @if ($result->booking_type == 'instant')
                                            <span>
                                                <i class="icon icon-bolt text-beach h4"></i>
                                                {{ trans('messages.property_single.instant_book') }}
                                            </span>
                                            @endif
                                        </button>
                                    </div>
                                    @else
                                    <div class="alert alert-info text-center">
                                        This property is unlisted for booking.
                                    </div>
                                    @endif
                                    @endif


                                </div>
                                <input id="hosting_id" name="hosting_id" type="hidden" value="{{ $result->id }}">
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- erorr check here --}}
        <div class="row mt-sm-0 mobile mt-4">
            <div class="col-lg-8 col-xl-9 col-sm-12">
                <div class="row justify-content-center rounded border pb-5" id="listMargin">
                    <div class="col-md-12 mt-3 pl-4 pr-4">
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2><strong>{{ trans('messages.property_single.about_list') }}</strong> </h2>
                                    <p class="mt-4 text-justify">{{ $result->description->summary }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18">
                                                {{ trans('messages.activity_single.what_youll_do') }}</h2>
                                            <p>{{ $result->what_you_do }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-sm-12">
                                    <p class="mt-4 text-justify">{{ $result->description->description ?? '' }}</p>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12 col-sm-12"></div>
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18">
                                                {{ trans('messages.activity_single.whats_included') }}</h2>
                                            <p>{{ $result->what_include }}</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-9 col-sm-9">
                                    <div class="row">
                                        @php $i = 1 @endphp

                                        @php $count = round(count($amenities)/2) @endphp
                                        @foreach ($amenities as $all_amenities)
                                            @if ($i < 6)
                                                <div class="col-md-6 col-sm-6">
                                                    <div>
                                                        @if(file_exists(public_path('images/symbols/' . $all_amenities->symbol)))
                                                        <img src="{{ asset('public/images/symbols/' . $all_amenities->symbol) }}" width="20">
                                                        @else
                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                        @endif
                                                        @if ($all_amenities->status == null)
                                                            <del>
                                                        @endif
                                                        {{ $all_amenities->title }}
                                                        @if ($all_amenities->status == null)
                                                            </del>
                                                        @endif
                                                    </div>
                                                </div>
                                                @php $i++ @endphp
                                            @endif
                                        @endforeach

                                        <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                            <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                    data-toggle="modal" data-target="#exampleModalCenter">
                                                + {{ trans('messages.property_single.more') }}
                                            </button>
                                        </div>

                                        <div class="row">
                                            <!-- Modal -->
                                            <div class="modal fade z-index-high mt-5" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="w-100 pt-3">
                                                                <h5 class="modal-title text-20 font-weight-700 text-center"
                                                                    id="exampleModalLongTitle">
                                                                    {{ trans('messages.property_single.amenity') }}</h5>
                                                            </div>

                                                            <div>
                                                                <button type="button" class="close text-28 filter-cancel mr-2" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <div class="modal-body pb-5">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="row">
                                                                        @php $i = 1 @endphp
                                                                        @foreach ($amenities as $all_amenities)
                                                                            @if ($i > 6)
                                                                                <div class="col-md-6 col-sm-6 mt-3">
                                                                                    <div>
                                                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                                                        @if ($all_amenities->status == null)
                                                                                            <del>
                                                                                        @endif
                                                                                        {{ $all_amenities->title }}
                                                                                        @if ($all_amenities->status == null)
                                                                                            </del>
                                                                                        @endif
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            @php $i++ @endphp
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <hr>

                            {{-- <div class="row">
                                <div class="col-md-3 col-sm-3">
                                    <div class="d-flex h-100">
                                        <div class="align-self-center">
                                            <h2 class="font-weight-700 text-18">{{ trans('messages.property_single.price') }}</h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-9 col-sm-9">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <div>
                                                <i class="fa fa-minus-circle text-13 mr-2" style="color: #5d717fa2" aria-hidden="true"></i>
                                                {{ trans('messages.property_single.extra_people') }}:
                                                <strong>
                                                    @if ($result->price->guest_fee != 0)
                                                        <span> {!! moneyFormat($symbol, $result->price->guest_fee) !!} /
                                                            {{ trans('messages.property_single.after_night') }}
                                                            {{ $result->price->guest_after }}
                                                            {{ trans('messages.property_single.guests') }}</span>
                                                    @else
                                                        <span>{{ trans('messages.property_single.no_charge') }}</span>
                                                    @endif
                                                </strong>
                                            </div>

                                            <div>
                                                <i class="fa fa-arrow-down text-13 mr-2" style="color: #5d717fa2" aria-hidden="true"></i>
                                                {{ trans('messages.property_single.weekly_discount') }} (%):
                                                @if ($result->price->weekly_discount != 0)
                                                    <strong> <span id="weekly_price_string">{!! moneyFormat($symbol, $result->price->weekly_discount) !!}</span>
                                                        /{{ trans('messages.property_single.week') }}</strong>
                                                @else
                                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol, $result->price->weekly_discount) !!}</span>
                                                        /{{ trans('messages.property_single.week') }}</strong>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6">
                                            <div>
                                                <i class="fa fa-arrow-down text-13 mr-2" style="color: #5d717fa2" aria-hidden="true"></i>
                                                {{ trans('messages.property_single.monthly_discount') }} (%):
                                                @if ($result->price->monthly_discount != 0)
                                                    <strong>
                                                        <span id="weekly_price_string">{!! moneyFormat($symbol, $result->price->monthly_discount) !!}</span>
                                                        /{{ trans('messages.property_single.month') }}
                                                    </strong>
                                                @else
                                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol, $result->price->monthly_discount) !!}</span>
                                                        /{{ trans('messages.property_single.month') }}</strong>
                                                @endif
                                            </div>

                                            <!-- weekend price -->
                                            @if ($result->price->weekend_price > 0)
                                                <div>
                                                    <i class="fa fa-calendar-minus text-13 mr-2" style="color: #5d717fa2" aria-hidden="true"></i>
                                                    {{ trans('messages.listing_price.weekend_price') }}:
                                                    <strong>
                                                        <span id="weekly_price_string">{!! $symbol !!} {{ $result->price->weekend_price }}</span> /
                                                        {{ trans('messages.listing_price.weekend') }}
                                                    </strong>
                                                </div>
                                            @endif
                                            <!-- end weekend price -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr> --}}

                            <!--popup slider-->
                            <div class="d-none" id="showSlider">
                                <div id="ninja-slider">
                                    <div class="slider-inner">
                                        <ul>
                                            @foreach ($activity_photos as $row_photos)
                                                <li>
                                                    <a class="ns-img" href="{{ url('public/images/activity/' . $activity_id . '/' . $row_photos->photo) }}" aria-label="photo"></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <!--Start Reviews-->
                        @if (!$result->reviews->count())
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2><strong>{{ trans('messages.reviews.no_reviews_yet') }}</strong></h2>
                                    </div>

                                    @if ($result->user->reviews->count())
                                        <div class="col-md-12">
                                            <p>{{ trans_choice('messages.reviews.review_other_properties', $result->user->guest_review, ['count' => $result->user->guest_review]) }}</p>
                                            <p class="mt-5 mb-4 text-center">
                                                <a href="{{ url('users/show/' . $result->user->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">{{ trans('messages.reviews.view_other_reviews') }}</a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex">
                                            <div>
                                                <h2 class="text-20"><strong> {{ trans_choice('messages.reviews.review', $result->guest_review) }}</strong></h2>
                                            </div>

                                            <div class="ml-4">
                                                <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf('%.1f', $result->avg_rating) }}
                                                    ({{ $result->guest_review }})</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="font-weight-700 text-16">{{ trans('messages.property_single.summary') }}</h3>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mt-3 rounded border p-4 pt-3 pb-3">
                                            <div class="row justify-content-between">
                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.accuracy') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->accuracy_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.location') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->location_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->location_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4 class="text-truncate">{{ trans('messages.reviews.communication') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->communication_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->communication_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.checkin') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->checkin_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.cleanliness') }}</h4>
                                                        </div>

                                                        <div>
                                                            <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                                                <div class="progress-bar">
                                                                    <span></span>
                                                                </div>
                                                            </progress>
                                                            <span> {{ sprintf('%.1f', $result->cleanliness_avg_rating) }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-xl-5">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <h4>{{ trans('messages.reviews.value') }}</h4>
                                                        </div>

                                                        <div>
                                                            <ul>
                                                                <li>
                                                                    <progress max="5" value="{{ $result->value_avg_rating }}">
                                                                        <div class="progress-bar">
                                                                            <span></span>
                                                                        </div>
                                                                    </progress>
                                                                    <span> {{ sprintf('%.1f', $result->value_avg_rating) }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="row">
                                    @foreach ($result->reviews as $row_review)
                                        @if ($row_review->reviewer == 'guest')
                                            <div class="col-12 mt-4 mb-2">
                                                <div class="d-flex">
                                                    <div class="">
                                                        <div class="media-photo-badge text-center">
                                                            <a href="{{ url('users/show/' . $row_review->user->id) }}">
                                                                <img alt="{{ $row_review->user->first_name }}" class="" src="{{ $row_review->user->profile_src }}" title="{{ $row_review->user->first_name }}">
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="ml-2 pt-2">
                                                        <a href="{{ url('users/show/' . $row_review->user->id) }}">
                                                            <h2 class="text-16 font-weight-700">{{ $row_review->user->full_name }}</h2>
                                                        </a>
                                                        <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2">
                                                <div class="background text-15">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($row_review->rating >= $i)
                                                            <i class="fa fa-star secondary-text-color"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p class="mt-2 pr-4 text-justify">{{ $row_review->message }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-4">
                                @if ($result->user->reviews->count() - $result->reviews->count())
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mt-2 text-center">
                                                <a target="blank" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" href="{{ url('users/show/' . $result->user->id) }}">
                                                    <span>{{ trans('messages.reviews.view_other_reviews') }}</span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                        <hr>
                        <!--End Reviews-->
                        <div class="mt-5">
                            <div class="col-md-12">
                                <div class="clearfix"></div>
                                <h2><strong>{{ trans('messages.property_single.about_host') }}</strong></h2>
                                <div class="d-flex mt-4">
                                    <div class="">
                                        <div class="media-photo-badge text-center">
                                            <a href="{{ url('users/show/' . $result->host_id) }}"><img alt="{{ $result->user->first_name }}" class="" src="{{ $result->user->profile_src }}" title="{{ $result->user->first_name }}"></a>
                                        </div>
                                    </div>

                                    <div class="ml-2 pt-3">
                                        <a href="{{ url('users/show/' . $result->host_id) }}">
                                            <h2 class="text-16 font-weight-700 mb-0">{{ $result->user->full_name }}</h2>
                                        </a>
                                        <p class="small mb-0">{{ trans('messages.users_show.member_since') }} {{ date('F Y', strtotime($result->user->created_at)) }}</p>
                                        @if ($result->user->is_verified && $result->user->verified_at)
                                        <small class="mb-0 d-inline-block">
                                            <svg width="16" height="16" fill="currentColor" class="bi bi-shield-shaded mb-1" viewBox="0 0 16 16" style="color:var(--scheme-color)">
                                                <path fill-rule="evenodd" d="M8 14.933a.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067v13.866zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                            </svg>
                                            <strong style="color:var(--scheme-color)">Verified</strong>
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid container-fluid-90 mt-70">
        <div class="row mt-5">
            <div class="col-md-12">
                <div id="room-detail-map" class="single-map-w">
                    {!! base64_decode($result->embeded_map) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid container-fluid-90 mt-70 mb-5">
        @if (count($similar) != 0)
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center-sm text-20 font-weight-700">{{ trans('messages.property_single.similar_list') }}</h2>
                </div>
            </div>

            <div class="row m-0 mt-5 mb-5">
                @foreach ($similar->slice(0, 8) as $row_similar)
                    <div class="col-md-6 col-lg-4 col-xl-3 mt-4 p-2 pl-4 pr-4">
                        <div class="card h-100 card-1 border">
                            <div class="grid">
                                <a href="{{ $row_similar->slug }}">
                                    <figure class="effect-milo">
                                        <img src="{{ $row_similar->cover_photo }}" class="room-image-container200" alt="img11" />
                                        <figcaption>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>

                            <div class="card-body p-0 pl-1 pr-1">
                                <div class="d-flex">
                                    <div>
                                        <div class="profile-img pl-2 pr-1">
                                            <a href="{{ url('users/show/' . $row_similar->host_id) }}"><img src="{{ $row_similar->user->profile_src }}" alt="profile-photo"></a>
                                        </div>
                                    </div>

                                    <div class="text p-2">
                                        <a class="text-color text-color-hover" href="{{ url('activities/' . $row_similar->slug) }}">
                                            <h4 class="text-16 font-weight-700 text"> {{ $row_similar->name }}</h4>
                                        </a>
                                        <p class="text-14 text mt-2 mb-0"><i class="fas fa-map-marker-alt"></i>
                                            {{ $row_similar->property_address->city ?? '' }}</p>
                                    </div>
                                </div>

                                <div class="review-0 p-3">
                                    <div class="d-flex justify-content-between">

                                        <div>
                                            <span><i class="fa fa-star text-14 secondary-text-color"></i>
                                                @if ($row_similar->reviews_count)
                                                    {{ $row_similar->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $row_similar->reviews_count }})
                                            </span>
                                        </div>


                                        <div>
                                            <span class="font-weight-700">{!! moneyFormat($row_similar->price->currency->symbol ?? '', $row_similar->price->price) !!}</span> / {{ trans('messages.activity_single.person') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @push('css')
        <style>
            .mobile {
                display: none !important;
            }

            @media only screen and (max-width: 992px) {
                .desktop {
                    display: none !important;
                }

                .mobile {
                    display: block !important;
                }
            }
        </style>
    @endpush

    @push('scripts')
        {{-- <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&libraries=places'></script> --}}
        @auth
            <script src="{{ url('public/js/sweetalert.min.js') }}"></script>
        @endauth
        {{-- <script type="text/javascript" src="{{ url('public/js/locationpicker.jquery.min.js') }}"></script> --}}
        <script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/js/ninja/ninja-slider.js') }}"></script>
        <!-- daterangepicker -->
        <script type="text/javascript" src="{{ url('public/js/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/js/daterangepicker.min.js') }}"></script>
        <script type="text/javascript" src="{{ url('public/js/daterangecustom.js') }}"></script>

        <script type="text/javascript">
            let back = 0;
            $(function() {
                var checkin = $('#startDate').val();
                var checkout = $('#endDate').val();
                var page = 'single'
                dateRangeBtn(checkin, checkout, page, '{{ $date_format }}');

            });

            $("#view-calendar").on("click", function() {
                return $("#startDate").trigger("select");
            })


            @auth
            $(document).on('click', '.book_mark_change', function(event) {
                event.preventDefault();
                var activity_id = $(this).data("id");
                var property_status = $(this).data("status");
                var user_id = "{{ Auth::id() }}";
                var dataURL = APP_URL + '/add-edit-book-mark';
                var that = this;
                if (property_status == "1") {
                    var title = "{{ trans('messages.favourite.remove') }}";

                } else {

                    var title = "{{ trans('messages.favourite.add') }}";
                }

                swal({
                        title: title,
                        icon: "warning",
                        buttons: {
                            cancel: {
                                text: "{{ trans('messages.general.no') }}",
                                value: null,
                                visible: true,
                                className: "btn btn-outline-danger text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5",
                                closeModal: true,
                            },
                            confirm: {
                                text: "{{ trans('messages.general.yes') }}",
                                value: true,
                                visible: true,
                                className: "btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5",
                                closeModal: true
                            }
                        },
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {

                            $.ajax({
                                url: dataURL,
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'id': activity_id,
                                    'user_id': user_id,
                                },
                                type: 'post',
                                dataType: 'json',
                                success: function(data) {

                                    $(that).removeData('status')
                                    if (data.favourite.status == 'Active') {
                                        $(that).css('color', 'forestgreen');
                                        $(that).attr("data-status", 1);
                                        swal('success', '{{ trans('messages.success.favourite_add_success') }}');

                                    } else {
                                        $(that).css('color', 'black');
                                        $(that).attr("data-status", 0);
                                        swal('success', '{{ trans('messages.success.favourite_remove_success') }}');
                                    }
                                }
                            });

                        }
                    });
            });
            @endauth


            $(function() {
                var checkin = $('#url_checkin').val();
                var checkout = $('#url_checkout').val();
                var guest = $('#url_guests').val();
                price_calculation(checkin, checkout, guest);
            });

            $('#number_of_guests').on('change', function() {
                price_calculation('', '', '');
            });

            function price_calculation(checkin, checkout, guest) {
                var checkin = checkin != '' ? checkin : $('#startDate').val();
                var checkout = checkout != '' ? checkout : $('#endDate').val();
                var guest = guest != '' ? guest : $('#number_of_guests').val();
                if (checkin != '' && checkout != '' && guest != '') {
                    var activity_id = $('#activity_id').val();
                    var dataURL = '{{ url('activity/get-price') }}';
                    $.ajax({
                        url: dataURL,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'checkin': checkin,
                            'checkout': checkout,
                            'guest_count': guest,
                            'activity_id': activity_id,
                        },
                        type: 'post',
                        dataType: 'json',
                        beforeSend: function() {
                            // $('.price_table').addClass('d-none');
                            show_loader();
                        },
                        success: function(result) {
                            $('.append_date').remove();
                            if (result.status == 'Not available') {
                                $('.book_btn').addClass('d-none');
                                $('.booking-subtotal').addClass('d-none');
                                $('#book_it_disabled').removeClass('d-none');
                            } else if (result.status == 'minimum stay') {
                                $('.book_btn').addClass('d-none');
                                $('.booking-subtotal').addClass('d-none');
                                $('#book_it_disabled').addClass('d-none');
                                $('#minimum_disabled').removeClass('d-none');
                                $('#minimum_disabled_message').text(result.minimum);
                            } else {

                                //showing custom price in info icon
                                if (!jQuery.isEmptyObject(result.different_price_dates)) {
                                    var output = "{{ trans('messages.listing_price.custom_price') }} <br/>";
                                    for (var ical_date in result.different_price_dates) {
                                        output += "{{ __('messages.account_transaction.date') }}: " + ical_date + " | {{ __('messages.utility.price') }}: " + "{{ $symbol }}" + result.different_price_dates[ical_date] + " <br>";
                                    }

                                    $("#custom_price").attr("data-original-title", output);
                                    $('#custom_price').tooltip({
                                        'placement': 'top'
                                    });
                                    $('#custom_price').show();

                                } else {
                                    $('#custom_price').addClass('d-none');
                                }


                                var append_date = ""

                                for (var i = 0; i < result.date_with_price.length; i++) {

                                    append_date += '<tr class="append_date">' +
                                        '<td class="pl-4">' +
                                        result.date_with_price[i]['date'] +
                                        '</td>' +
                                        '<td class="pl-4 text-right"> <span  id="" value="">' + result.date_with_price[i]['price'] + '</span></td>' +
                                        '</tr>';

                                }

                                var tableBody = $("table tbody");
                                tableBody.first().prepend(append_date);


                                $('.additional_price').removeClass('d-none');
                                $('.security_price').removeClass('d-none');
                                $('.cleaning_price').removeClass('d-none');
                                $('.iva_tax').removeClass('d-none');
                                $('.accomodation_tax').removeClass('d-none');
                                $("#total_day_count").html(result.total_days);
                                $("#total_person_count").html(result.total_persons);
                                $('#total_person_price').html(result.total_person_price_with_symbol);
                                $('#service_fee').html(result.service_fee_with_symbol);
                                $('#discount').html(result.discount_with_symbol);

                                if (result.iva_tax != 0) $('#iva_tax').html(result.iva_tax_with_symbol);
                                else $('.iva_tax').addClass('d-none');
                                if (result.accomodation_tax != 0) $('#accomodation_tax').html(result.accomodation_tax_with_symbol);
                                else $('.accomodation_tax').addClass('d-none');

                                if (result.additional_guest != 0) $('#additional_guest').html(result.additional_guest_fee_with_symbol);
                                else $('.additional_price').addClass('d-none');
                                if (result.security_fee != 0) $('#security_fee').html(result.security_fee_with_symbol);
                                else $('.security_price').addClass('d-none');
                                if (result.cleaning_fee != 0) $('#cleaning_fee').html(result.cleaning_fee_with_symbol);
                                else $('.cleaning_price').addClass('d-none');
                                $('#total').html(result.total_with_symbol);
                                //$('#total_night_price').html(result.total_night_price);

                                $('.booking-subtotal').removeClass('d-none');
                                $('#book_it_disabled').addClass('d-none');
                                $('#minimum_disabled').addClass('d-none');
                                $('.book_btn').removeClass('d-none');
                            }

                            var host = "{{ $result->host_id == @Auth::guard('users')->user()->id ? '1' : '' }}";
                            if (host == '1') $('.book_btn').addClass('d-none');
                        },
                        error: function(request, error) {
                            // This callback function will trigger on unsuccessful action
                            console.log(error);
                        },
                        complete: function() {
                            $('.price_table').removeClass('d-none');
                            hide_loader();
                        }
                    });
                }
            }


            $("#save_btn").on("click", function(e) {
                $("#save_btn").attr("disabled", true);
                $(".spinner").removeClass('d-none');
                $('#booking_form').submit();
            });

            window.onbeforeunload = function(evt) {
                if (back) {
                    $("#save_btn").attr("disabled", false);
                    $(".spinner").addClass('d-none');
                    back = 0;
                } else {
                    back++;
                }

            }


            $('.more-btn').on('click', function() {
                var name = $(this).attr('data-rel');
                $('#' + name + '_trigger').addClass('d-none');
                $('#' + name + '_after').removeClass('d-none');
            });

            $('.less-btn').on('click', function() {
                var name = $(this).attr('data-rel');
                $('#' + name + '_trigger').removeClass('d-none');
                $('#' + name + '_after').addClass('d-none');
            });

            // setTimeout(function() {

            //     $('#room-detail-map').locationpicker({
            //         location: {
            //             latitude: "{{ $result->address->latitude }}",
            //             longitude: "{{ $result->address->longitude }}"
            //         },
            //         radius: 0,
            //         addressFormat: "",
            //         markerVisible: false,
            //         markerInCenter: false,
            //         enableAutocomplete: true,
            //         scrollwheel: false,
            //         oninitialized: function(component) {
            //             setCircle($(component).locationpicker('map').map);
            //         }

            //     });

            // }, 5000);

            // function setCircle(map) {
            //     var citymap = {
            //         loccenter: {
            //             center: {
            //                 lat: 41.878,
            //                 lng: -87.629
            //             },
            //             population: 240
            //         },
            //     };

            //     var cityCircle = new google.maps.Circle({
            //         strokeColor: '#329793',
            //         strokeOpacity: 0.8,
            //         strokeWeight: 2,
            //         fillColor: '#329793',
            //         fillOpacity: 0.35,
            //         map: map,
            //         center: {
            //             lat: {{ $result->address->latitude }},
            //             lng: {{ $result->address->longitude }}
            //         },
            //         radius: citymap['loccenter'].population
            //     });
            // }

            function lightbox(idx) {
                //show the slider's wrapper: this is required when the transitionType has been set to "slide" in the ninja-slider.js
                $('#showSlider').removeClass("d-none");
                nslider.init(idx);
                $("#ninja-slider").addClass("fullscreen");
            }

            function fsIconClick(isFullscreen) { //fsIconClick is the default event handler of the fullscreen button
                if (isFullscreen) {
                    $('#showSlider').addClass("d-none");
                }
            }

            function show_loader() {
                $('#loader').removeClass('d-none');
                $('#pagination').addClass('d-none');
            }

            function hide_loader() {
                $('#loader').addClass('d-none');
                $('#pagination').removeClass('d-none');
            }

            window.twttr = (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0],
                    t = window.twttr || {};
                if (d.getElementById(id)) return t;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://platform.twitter.com/widgets.js";
                fjs.parentNode.insertBefore(js, fjs);
                t._e = [];
                t.ready = function(f) {
                    t._e.push(f);
                };

                return t;
            }(document, "script", "twitter-wjs"));
        </script>
    @endpush
@stop
@push('css')
    <style>
        #room-detail-map iframe {
            width: 100% !important;
        }
    </style>
@endpush
