@extends('template')
@push('css')
	<link rel="stylesheet" type="text/css" href="{{ url('public/css/daterangepicker.min.css')}}" />
    <link href="{{ url('public/css/bootstrap-slider.min.css') }}" rel="stylesheet" type="text/css" />
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
	<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type')}}">

    <div class="mt-5 pt-5 text-center">
        <div class="mt-5">
            <button type="button" id="more_filters" class="font-weight-500 btn text-16 border border-r-25 pl-4 pr-4" data-toggle="modal" data-target="#filterModalCenter">
                Filters
            </button>
        </div>
    </div>
	<section class="mt-4 magic-ball magic-ball-about pb-5">
		<div class="container-fluid container-fluid-90">
			<div class="row">
                <div class="recommandedhead section-intro text-center mt-70">
                    <p class="item animated fadeIn text-24 font-weight-700 m-0">{{trans('messages.home.recommended_hotel')}}</p>
					{{-- <p class="mt-2">{{trans('messages.home.recommended_hotel_slogan')}}</p> --}}
					<p class="mt-2">{{trans('Esteemed guests are welcome to relax and unwind in a quiet and elegant stay in the wide range of hotels and enjoy a genuine experience of leisure, pleasure, gastronomy and wellness with their selected hotel.')}}</p>
				</div>
			</div>

			@if(!$hotels->isEmpty())
				<div class="row mt-5">
					@foreach($hotels as $property)
					<div class="col-md-6 col-lg-4 col-xl-3 pl-3 pr-3 pb-3 mt-4">
						<div class="card h-100 card-shadow card-1">
							<div class="grid">
								<a href="properties/{{ $property->slug }}" aria-label="{{ $property->name}}">
									<figure class="effect-milo">
										<img src="{{ $property->cover_photo }}" class="room-image-container200" alt="{{ $property->name}}"/>
										<figcaption>
										</figcaption>
									</figure>
								</a>
							</div>

							<div class="card-body p-0 pl-1 pr-1">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2">
											<a href="{{ url('users/show/'.$property->host_id) }}"><img src="{{ $property->users->profile_src }}" alt="{{ $property->name}}" class="img"></a>
										</div>
									</div>

									<div class="p-2 text">
										<a class="text-color text-color-hover" href="properties/{{ $property->slug }}">
											<p class="text-16 font-weight-700 text"> {{ $property->name}}</p>
										</a>
										<p class="text-13 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{$property->property_address->city ?? ''}}</p>
									</div>
								</div>

								<div class="review-0 p-3">
									<div class="d-flex justify-content-between">

										<div class="d-flex">
                                            <div class="d-flex align-items-center">
											<span><i class="fa fa-star text-14 secondary-text-color"></i>
												@if( $property->guest_review)
                                                    {{ $property->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $property->guest_review }})</span>
                                            </div>

                                            <div class="">
                                                @auth
                                                    <a class="btn btn-sm book_mark_change" data-status="{{$property->book_mark}}" data-id="{{$property->id}}" style="color:{{($property->book_mark == true) ? 'var(--scheme-color)':''}}; ">
                                                    <span style="font-size: 22px;">
                                                        <i class="fas fa-heart pl-2"></i>
                                                    </span>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>


										<div>
											<span class="font-weight-700">{!! moneyFormat( $property->property_price->currency->symbol, $property->property_price->price) !!}</span> / {{trans('messages.property_single.night')}}
										</div>
									</div>
								</div>

								<div class="card-footer text-muted p-0 border-0">
									<div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
										<div>
											<ul class="list-inline">
												<li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-2 bg-light text-dark">
														<div class="vtooltip"> <i class="fas fa-user-friends"></i> {{ $property->accommodates }}
														<span class="vtooltiptext text-14">{{ $property->accommodates }} {{trans('messages.property_single.guest')}}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bed"></i> {{ $property->bedrooms }}
														<span class="vtooltiptext  text-14">{{ $property->bedrooms }} {{trans('messages.property_single.bedroom')}}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bath"></i> {{ $property->bathrooms }}
														<span class="vtooltiptext  text-14 p-2">{{ $property->bathrooms }} {{trans('messages.property_single.bathroom')}}</span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
            @else
                <p class="text-center mt-5 pt-5">No property listed yet</p>
			@endif
		</div>
	</section>
	<section class="mt-4 magic-ball magic-ball-about pb-5">
		<div class="container-fluid container-fluid-90">
			<div class="row">
				<div class="recommandedhead section-intro text-center mt-70">
					<p class="item animated fadeIn text-24 font-weight-700 m-0">{{trans('messages.home.recommended_guest_house')}}</p>
					{{-- <p class="mt-2">{{trans('messages.home.recommended_guest_house_slogan')}}</p> --}}
					<p class="mt-2">{{trans('There is nothing like staying at a guest house or home for real comfort. Enjoy Glimpse of local culture and homely feel everywhere in Pakistan.')}}</p>
				</div>
			</div>

			@if(!$guestHouses->isEmpty())
				<div class="row mt-5">
					@foreach($guestHouses as $property)
					<div class="col-md-6 col-lg-4 col-xl-3 pl-3 pr-3 pb-3 mt-4">
						<div class="card h-100 card-shadow card-1">
							<div class="grid">
								<a href="properties/{{ $property->slug }}" aria-label="{{ $property->name}}">
									<figure class="effect-milo">
										<img src="{{ $property->cover_photo }}" class="room-image-container200" alt="{{ $property->name}}"/>
										<figcaption>
										</figcaption>
									</figure>
								</a>
							</div>

							<div class="card-body p-0 pl-1 pr-1">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2">
											<a href="{{ url('users/show/'.$property->host_id) }}">
                                                <img src="{{ $property->users->profile_src }}" alt="{{ $property->name}}" class="img">
                                            </a>
										</div>
									</div>

									<div class="p-2 text">
										<a class="text-color text-color-hover" href="properties/{{ $property->slug }}">
											<p class="text-16 font-weight-700 text"> {{ $property->name}}</p>
										</a>
										<p class="text-13 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{$property->property_address->city}}</p>
									</div>
								</div>

								<div class="review-0 p-3">
									<div class="d-flex justify-content-between">

										<div class="d-flex">
                                            <div class="d-flex align-items-center">
											<span><i class="fa fa-star text-14 secondary-text-color"></i>
												@if( $property->guest_review)
                                                    {{ $property->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $property->guest_review }})</span>
                                            </div>

                                            <div class="">
                                                @auth
                                                    <a class="btn btn-sm book_mark_change" data-status="{{$property->book_mark}}" data-id="{{$property->id}}" style="color:{{($property->book_mark == true) ? 'var(--scheme-color)':''}}; ">
                                                        <span style="font-size: 22px;">
                                                            <i class="fas fa-heart pl-2"></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>


										<div>
											<span class="font-weight-700">{!! moneyFormat( $property->property_price->currency->symbol, $property->property_price->price) !!}</span> / {{trans('messages.property_single.night')}}
										</div>
									</div>
								</div>

								<div class="card-footer text-muted p-0 border-0">
									<div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
										<div>
											<ul class="list-inline">
												<li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-2 bg-light text-dark">
														<div class="vtooltip"> <i class="fas fa-user-friends"></i> {{ $property->accommodates }}
														<span class="vtooltiptext text-14">{{ $property->accommodates }} {{trans('messages.property_single.guest')}}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bed"></i> {{ $property->bedrooms }}
														<span class="vtooltiptext  text-14">{{ $property->bedrooms }} {{trans('messages.property_single.bedroom')}}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bath"></i> {{ $property->bathrooms }}
														<span class="vtooltiptext  text-14 p-2">{{ $property->bathrooms }} {{trans('messages.property_single.bathroom')}}</span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
            @else
                <p class="text-center mt-5 pt-5">No property listed yet</p>
            @endif
		</div>
	</section>
	<section class="mt-4 magic-ball magic-ball-about pb-5">
		<div class="container-fluid container-fluid-90">
			<div class="row">
				<div class="recommandedhead section-intro text-center mt-70">
					<p class="item animated fadeIn text-24 font-weight-700 m-0">{{trans('messages.home.recommended_activities')}}</p>
					{{-- <p class="mt-2">{{trans('messages.home.recommended_activities_slogan')}}</p> --}}
					<p class="mt-2">{{trans('The purpose of life, after all, is to live it, to taste experience to the utmost, to reach out eagerly and without fear for a newer and richer experience. You have a wide range of Adventures and Activities on TravelOBug for feeding your travel bug.')}}</p>
				</div>
			</div>

			@if(!$activities->isEmpty())
				<div class="row mt-5">
					@foreach($activities as $activity)
					<div class="col-md-6 col-lg-4 col-xl-3 pl-3 pr-3 pb-3 mt-4">
						<div class="card h-100 card-shadow card-1">
							<div class="grid">
								<a href="{{ route('activity.single', $activity->slug) }}" aria-label="{{ $activity->name}}">
									<figure class="effect-milo">
										<img src="{{ $activity->cover_photo }}" class="room-image-container200" alt="{{ $activity->name}}"/>
										<figcaption>
										</figcaption>
									</figure>
								</a>
							</div>

							<div class="card-body p-0 pl-1 pr-1">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2">
											<a href="{{ url('users/show/'.$activity->host_id) }}"><img src="{{ $activity->user->profile_src }}" alt="{{ $activity->name}}" class="img"></a>
										</div>
									</div>

									<div class="p-2 text">
										<a class="text-color text-color-hover" href="{{ route('activity.single', $activity->slug) }}">
											<p class="text-16 font-weight-700 text"> {{ $activity->name}}</p>
										</a>
										<p class="text-13 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{$activity->address->city}}</p>
									</div>
								</div>

								<div class="review-0 p-3">
									<div class="d-flex justify-content-between">

										<div class="d-flex">
                                            <div class="d-flex align-items-center">
											<span><i class="fa fa-star text-14 secondary-text-color"></i>
												@if( $activity->guest_review)
                                                    {{ $activity->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $activity->guest_review }})</span>
                                            </div>

                                            <div class="">
                                                @auth
                                                    <a class="btn btn-sm book_mark_change" data-status="{{$activity->book_mark}}" data-id="{{$activity->id}}" style="color:{{($activity->book_mark == true) ? 'var(--scheme-color)':''}}; ">
                                                    <span style="font-size: 22px;">
                                                        <i class="fas fa-heart pl-2"></i>
                                                    </span>
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>


										<div>
											<span class="font-weight-700">{!! moneyFormat( $activity->price->currency->symbol, $activity->price->price) !!}</span> / {{trans('messages.activity.person')}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
            @else
                <p class="text-center my-5 py-5">No activity listed yet</p>
			@endif
		</div>
	</section>

    <div class="modal fade mt-5 z-index-high" id="filterModalCenter" tabindex="-1" role="dialog" aria-labelledby="filterModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700" id="filterModalCenterTitle">{{ trans('messages.search.filters') }}</h5>
                    </div>

                    <div>
                        <button type="button" class="close text-28 mr-2" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body modal-body-filter">
                    <form action="{{ url('search') }}" id="filter_modal_form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <input type="radio" name="category" value="hotel" class="form-radio-input mt-2" id="filter_cat-hotel">
                                        <label class="form-radio-label mt-2 ml-25" for="filter_cat-hotel">Hotel</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <input type="radio" name="category" value="guest_house" class="form-radio-input mt-2" id="filter_cat-guest_house">
                                        <label class="form-radio-label mt-2 ml-25" for="filter_cat-guest_house">Guest House</label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <input type="radio" name="category" value="activities" class="form-radio-input mt-2" id="filter_cat-activities">
                                        <label class="form-radio-label mt-2 ml-25" for="filter_cat-activities">Activities</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h5 class="font-weight-700 text-24 mt-2 p-4" for="user_birthdate">{{ trans('messages.search.size') }}</h5>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                <div class="select col-sm-4">
                                    <select name="min_bedrooms" class="form-control" id="map-search-min-bedrooms">
                                        <option value="">{{ trans('messages.search.bedrooms') }}</option>
                                        @for($i=1;$i<=10;$i++)
                                            <option value="{{ $i }}" {{ ($bedrooms==$i)?'selected':''}}>
                                                {{ $i }} {{ trans('messages.search.bedrooms') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="select col-sm-4">
                                    <select name="min_bathrooms" class="form-control" id="map-search-min-bathrooms">
                                        <option value="">{{ trans('messages.search.bathrooms') }}</option>
                                        @for($i=0.5;$i<=8;$i+=0.5)
                                            <option class="bathrooms" value="{{ $i }}" {{ $bathrooms == $i?'selected':''}}>
                                                {{ ($i == '8') ? $i.'+' : $i }} {{ trans('messages.search.bathrooms') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="select col-sm-4">
                                    <select name="min_beds" class="form-control" id="map-search-min-beds">
                                        <option value="">{{ trans('messages.search.beds') }}</option>
                                        @for($i=1;$i<=16;$i++)
                                            <option value="{{ $i }}" {{ $beds == $i?'selected':''}}>
                                                {{ ($i == '16') ? $i.'+' : $i }} {{ trans('messages.search.beds') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h5 class="font-weight-700 text-24 pl-4" for="user_birthdate">{{ trans('messages.search.amenities') }}</h5>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">
                                @php $row_inc = 1 @endphp

                                @foreach($amenities as $row_amenities)
                                    @if($row_inc <= 4)
                                        <div class="col-md-6">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" name="amenities[]" value="{{ $row_amenities->id }}" class="form-check-input mt-2 amenities_array" id="map-search-amenities-{{ $row_amenities->id }}">
                                                <label class="form-check-label mt-2 ml-25" for="map-search-amenities-{{ $row_amenities->id }}"> {{ $row_amenities->title }}</label>
                                            </div>
                                        </div>
                                    @endif

                                    @php $row_inc++ @endphp
                                @endforeach

                                <div class="collapse" id="amenities-collapse">
                                    <div class="row">
                                        @php $amen_inc = 1 @endphp
                                        @foreach($amenities as $row_amenities)
                                            @if($amen_inc > 4)
                                                <div class="col-md-6 mt-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="amenities[]" value="{{ $row_amenities->id }}" class="form-check-input mt-2 amenities_array" id="map-search-amenities-{{ $row_amenities->id }}" ng-checked="{{ (in_array($row_amenities->id, $amenities_selected)) ? 'true' : 'false' }}">
                                                        <label class="form-check-label mt-2 ml-25" for="map-search-amenities-{{ $row_amenities->id }}"> {{ $row_amenities->title }}</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @php $amen_inc++ @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="cursor-pointer" data-toggle="collapse" data-target="#amenities-collapse" >
                                <span class="font-weight-600 ml-4"><u> Show all amenities</u></span>
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h5 class="font-weight-700 text-24 pl-4" for="user_birthdate">{{ trans('messages.search.property_type') }}</h5>
                        </div>

                        <div class="col-sm-12">
                            <div class="row mt-2">
                                @php $pro_inc = 1 @endphp
                                @foreach($property_type as $row_property_type => $value_property_type)
                                    @if($pro_inc <= 4)
                                        <div class="col-md-6">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" name="property_type[]" value="{{ $row_property_type }}" class="form-check-input mt-2" id="map-search-property_type-{{ $row_property_type }}">
                                                <label class="form-check-label mt-2 ml-25" for="map-search-property_type-{{ $row_property_type }}"> {{ $value_property_type}}</label>
                                            </div>
                                        </div>
                                    @endif
                                    @php $pro_inc++ @endphp
                                @endforeach

                                <div class="collapse" id="property-collapse">
                                    <div class="row">
                                        @php $property_inc = 1 @endphp
                                        @foreach($property_type as $row_property_type =>$value_property_type)
                                            @if($property_inc > 4)
                                                <div class="col-md-6 mt-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="property_type[]" value="{{ $row_property_type }}" class="form-check-input mt-2" id="map-search-property_type-{{ $row_property_type }}">
                                                        <label class="form-check-label mt-2 ml-25" for="map-search-property_type-{{ $row_property_type }}"> {{ $value_property_type}}</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @php $property_inc++ @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="cursor-pointer" data-toggle="collapse" data-target="#property-collapse" >
                                <span class="font-weight-600 text-16 ml-4"><u> Show all property type</u></span>
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3 mt-4">
                        <div class="col-sm-12">
                            <h5 class="font-weight-700 text-24 pl-4" for="user_birthdate">{{ trans('Price Filter') }}</h5>
                        </div>
                        <div class="btn text-16 border price-btn  pl-4 pr-4">
                            <span>{!! $currency_symbol!!}</span>
                            <span  id="minPrice">{{ $min_price }}</span>
                        </div>

                        <div class="pl-4 pr-4 pt-2 min-w-250">
                            <input id="price-range" data-provide="slider" data-slider-min="{{ $min_price }}" data-slider-max="{{ $max_price }}" data-slider-value="[{{ $min_price }},{{ $max_price }}]"/>
                        </div>

                        <div class="btn text-16 border price-btn  pl-4 pr-4 ">
                            <span>{!! $currency_symbol!!}</span>
                            <span  id="maxPrice">{{ $min_price }}</span>
                        </div>
                        <input type="hidden" name="min_price" id="min_price">
                        <input type="hidden" name="max_price" id="max_price">
                    </div>
                </form>
                </div>

                <div class="modal-footer p-4">
                    <button class="btn btn-outline-danger text-16 pl-3 pr-3 mr-4"  data-dismiss="modal">{{ trans('messages.search.cancel') }}</button>
                    <button class="btn vbtn-outline-success filter-apply text-16 mr-5 pl-3 pr-3 ml-2" type="submit" form="filter_modal_form" >{{ trans('messages.search.apply_filter') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&libraries=places'></script>
	<script type="text/javascript" src="{{ url('public/js/moment.min.js') }}"></script>
    @auth
        <script src="{{ url('public/js/sweetalert.min.js') }}"></script>
    @endauth
	<script type="text/javascript" src="{{ url('public/js/daterangepicker.min.js')}}"></script>
	<script type="text/javascript" src="{{ url('public/js/front.js') }}"></script>
	{{-- <script type="text/javascript" src="{{ url('public/js/front.min.js') }}"></script> --}}
	<script type="text/javascript" src="{{ url('public/js/daterangecustom.js')}}"></script>
    <script>
        $.fn.slider = null;
    </script>
    <script src="{{ url('public/js/bootstrap-slider.min.js') }}"></script>
	<script type="text/javascript">
        $("#price-range").slider();


        $("#price-range").on("slideStop", function(slideEvt) {
            var range       = $('#price-range').attr('data-value');
            range           = range.split(',');
            var min_price       = range[0];
            var max_price       = range[1];
            $('#minPrice').html(min_price);
            $('#maxPrice').html(max_price);
            $('#min_price').val(min_price);
            $('#max_price').val(max_price);
        });

		$(function() {
			dateRangeBtn(moment(),moment(), null, '{{$date_format}}');
		});

        @auth
        $(document).on('click', '.book_mark_change', function(event){
            event.preventDefault();
            var property_id = $(this).data("id");
            var property_status = $(this).data("status");
            var user_id = "{{Auth::id()}}";
            var dataURL = APP_URL+'/add-edit-book-mark';
            var that = this;
            if (property_status == "1")
            {
                var title = "{{trans('messages.favourite.remove')}}";

            } else {

                var title = "{{trans('messages.favourite.add')}}";
            }

            swal({
                title: title,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "{{trans('messages.general.no')}}",
                        value: null,
                        visible: true,
                        className: "btn btn-outline-danger text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5",
                        closeModal: true,
                    },
                    confirm: {
                        text: "{{trans('messages.general.yes')}}",
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
                            data:{
                                "_token": "{{ csrf_token() }}",
                                'id':property_id,
                                'user_id':user_id,
                            },
                            type: 'post',
                            dataType: 'json',
                            success: function(data) {

                                $(that).removeData('status')
                                if(data.favourite.status == 'Active') {
                                    $(that).css('color', 'var(--scheme-color)');
                                    $(that).attr("data-status", 1);
                                    swal('success', '{{trans('messages.success.favourite_add_success')}}');

                                } else {
                                    $(that).css('color', 'black');
                                    $(that).attr("data-status", 0);
                                    swal('success', '{{trans('messages.success.favourite_remove_success')}}');


                                }
                            }
                        });

                    }
                });
        });
        @endauth
	</script>
@endpush

