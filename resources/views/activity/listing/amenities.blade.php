	@extends('template', ['title' => "Activity Listing"])
	@section('main')
	<div class="margin-top-85">
		<div class="row m-0">
			<!-- sidebar start-->
			@include('users.sidebar')
			<!--sidebar end-->
			<div class="col-md-10">
				<div class="main-panel min-height mt-4">
					<div class="row justify-content-center">
						<div class="col-md-3 pl-4 pr-4">
							@include('activity.listing.sidebar')
						</div>

						<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
							<h4>Activity Amenities</h4>
							<form id="amenities_id" method="post" action="{{url('activity/listing/'.$result->id.'/'.$step)}}" accept-charset='UTF-8'>
								{{ csrf_field() }}
								@foreach ($amenities as $group)
								<div class="col-xs-6">
									<ul class="list-unstyled">
										@foreach($group as $amenity)
										<li>
											<span>&nbsp;&nbsp;</span>
											<label class="label-large label-inline amenity-label">
											<input type="checkbox" value="{{ $amenity->id }}" name="amenities[]" data-saving="" {{ in_array($amenity->id, $activity_amenities) ? 'checked' : '' }}> &nbsp;&nbsp;
											<span>{{ $amenity->title }}</span>
											</label>
											<span>&nbsp;</span>

											@if($amenity->description != '')
											<span data-toggle="tooltip" class="icon" title="{{ $amenity->description }}"></span>
											@endif
										</li>
										@endforeach
									</ul>
								</div>
								@endforeach

								<div class="col-md-12 p-0 mt-4 mb-5">
									<div class="row justify-content-between mt-4">
										<div class="mt-4">
											<a data-prevent-default="" href="{{ url('activity/listing/'.$result->id.'/location') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" >
											{{trans('messages.listing_description.back')}}
											</a>
										</div>

										<div class="mt-4">
											<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
												<span id="btn_next-text">{{trans('messages.listing_basic.next')}}</span>

											</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop

	@push('scripts')
	<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			$('#amenities_id').validate({
				rules: {
					'amenities[]': {
						required: true,
					}
				},
				submitHandler: function(form)
	            {
		            $("#btn_next").on("click", function (e)
	                {
	                	$("#btn_next").attr("disabled", true);
	                    e.preventDefault();
	                });


	                $(".spinner").removeClass('d-none');
	                $("#btn_next-text").text("{{trans('messages.listing_basic.next')}}..");
	                return true;
	            },
				messages: {
					'amenities[]': {
						required: "{{ __('messages.jquery_validation.required') }}",
					}
				},

				groups: {
				amenities: "amenities[]"
				},
				errorPlacement: function(error, element) {
				if (element.attr("name") == "amenities[]") {
					error.insertAfter("#at_least_one");
				} else {
					error.insertAfter(element);
				}
				},
			});
		});
	</script>
@endpush
