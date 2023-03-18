@extends('template', ['title' => "Activity Listing"])
@section('main')
<div class="mb-4 margin-top-85">
	<div class="row m-0">
		@include('users.sidebar')
		<div class="col-md-10  min-height">
			<div class="main-panel m-4 list-background border rounded-3">
				<h3 class="text-center mt-5 text-24 font-weight-700">{{trans('messages.property.list_space')}}</h3>
				<p class="text-center text-16 pl-4 pr-4">{{ $site_name }} {{trans('messages.property.property_title')}}.</p>
				<form id="list_space" method="post" action="{{route('user.activity.add')}}" class="mt-4" id="lys_form" accept-charset='UTF-8'>
					{{ csrf_field() }}
					<div class="box-body">
						<input type="hidden" name='host_id' value="{{ auth()->id() }}">
						<input type="hidden" name='street_number' id='street_number'>
						<input type="hidden" name='route' id='route'>
						<input type="hidden" name='postal_code' id='postal_code'>
						<input type="hidden" name='city' id='city'>
						<input type="hidden" name='state' id='state'>
						<input type="hidden" name='country' id='country'>
						<input type="hidden" name='latitude' id='latitude'>
						<input type="hidden" name='longitude' id='longitude'>


						<div class="form-group">
							<label for="activity_name" class="control-label col-sm-3">{{ trans('messages.activity.name') }} <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="activity_name" name="activity_name" placeholder="">
							</div>
							@if ($errors->has('activity_name'))
								<p class="error-tag">{{ $errors->first('activity_name') }}</p>
							@endif
							<div id="us3"></div>
						</div>

						<div class="form-group">
							<label for="activity_type_id" class="control-label col-sm-3">{{trans('messages.activity.type')}}<span class="text-danger">*</span></label>
							<div class="col-sm-6">
							<select name="activity_type_id" id="activity_type_id" class="form-control">
								<option value="">Select</option>
								@foreach($activityTypes as $key => $value)
									<option data-icon-class="icon-star-alt"  value="{{ $key }}">
									{{ $value }}
									</option>
								@endforeach
							</select>
							</div>
							@if ($errors->has('activity_type_id')) <p class="error-tag">{{ $errors->first('activity_type_id') }}</p> @endif
						</div>

						<div class="form-group">
							<label for="exampleInputPassword1" class="control-label col-sm-3">{{ trans('messages.property.city') }} <span class="text-danger">*</span></label>
							<div class="col-sm-6">
								<div class="position-relative">
									<input type="text" class="form-control text-16 address_input" id="front-search-address" name="map_address" placeholder="">
									<div class="address_html"></div>
								</div>
							</div>
							@if ($errors->has('map_address'))
								<p class="error-tag">{{ $errors->first('map_address') }}</p>
							@endif
							<div id="us3"></div>
						</div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="control-label col-sm-3">{{ trans('What you\'ll do') }} <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <div class="position-relative">
                                    <textarea class="form-control" aria-required="true" rows="7" id="what_you_do" name="what_you_do">{{ trans('What you\'ll do') }}</textarea>
                                </div>
                            </div>
                            @if ($errors->has('what_you_do'))
                                <p class="error-tag">{{ $errors->first('what_you_do') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="control-label col-sm-3">{{ trans('What includes') }} <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <div class="position-relative">
                                    <textarea class="form-control" aria-required="true" rows="7" id="what_include" name="what_include">{{ trans('What you\'ll do') }}</textarea>
                                </div>
                            </div>
                            @if ($errors->has('what_include'))
                                <p class="error-tag">{{ $errors->first('what_include') }}</p>
                            @endif
                        </div>
					</div>
					<div class="col-md-12">
						<div class="float-right">
							<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 mt-4 mb-4" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
								<span id="btn_next-text">{{trans('messages.property.continue')}}</span>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
@push('scripts')
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&libraries=places'></script>
	<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('public/js/locationpicker.jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('public/js/propertycreate.js') }}"></script>
	<script  type="text/javascript">
		$(document).ready(function () {
			$('#list_space').validate({
				rules: {
					activity_type_id: {
						required: true
					},
					activity_name: {
						required: true
					},
					front-search-address: {
						required: true
					},
                    what_you_do: {
                        required: true,
                        maxlength: 1000
                    },
                    what_include: {
                        required: true,
                        maxlength: 1000
                    },
				},
				submitHandler: function(form)
	            {
	        		$("#btn_next").on("click", function (e)
	                {
	                	$("#btn_next").attr("disabled", true);
	                    e.preventDefault();
	                });

	                $(".spinner").removeClass('d-none');
	                $("#btn_next-text").text("{{trans('messages.property.continue')}}..");
	                return true;
	            },
				messages: {
					activity_type_id: {
						required:  "{{ __('messages.jquery_validation.required') }}",
					},
					activity_name: {
						required:  "{{ __('messages.jquery_validation.required') }}",
					},
					front-search-address: {
						required:  "{{ __('messages.jquery_validation.required') }}",
					},
                    what_you_do: {
                        required:  "{{ __('messages.jquery_validation.required') }}",
                    },
                    what_include: {
                        required:  "{{ __('messages.jquery_validation.required') }}",
                    },
				}
			});
		});
	</script>
@endpush
