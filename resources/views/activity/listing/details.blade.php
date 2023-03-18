@extends('template', ['title' => "Activity Listing"])

@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10">
			<div class="main-panel mt-4 min-height">
				<div class="row">
					<div class="col-md-3 mt-4 mt-sm-0 pl-4 pr-4">
						@include('activity.listing.sidebar')
					</div>

					<div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4">
						<form method="post" action="{{url('activity/listing/'.$result->id.'/'.$step)}}" class='signup-form login-form' accept-charset='UTF-8' id="listing_det">
							{{ csrf_field() }}
							<div class="col-md-12 pb-4 p-0 border rounded-3 mt-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3 text-capitalize">{{trans('messages.listing_description.detail')}}</h4>
								</div>
									<div class="row mt-4">
										<div class="col-md-12 pl-5 pr-5">
											<label class="label-large">{{trans('messages.listing_description.detail')}} {{trans('messages.listing_description.description')}}</label>
                                            <textarea class="form-control" name="description" rows="4" placeholder="">{{ $result->description->description }}</textarea>
										</div>
									</div>


							</div>

							<div class="col-md-12 p-0 mt-4 mb-5">
								<div class="row m-0 justify-content-between">
									<div class="mt-4">
										<a  href="{{ url('activity/listing/'.$result->id.'/description') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700  pt-3 pb-3 pl-5 pr-5">
										{{trans('messages.listing_description.back')}}
										</a>
									</div>

									<div class="mt-4">
										<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" id="btn_next"><i class="spinner fa fa-spinner fa-spin d-none" ></i>
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
		$('#listing_det').validate({
			submitHandler: function(form)
            {
                $("#btn_next").on("click", function (e)
                {
                	$("#btn_next").attr("disabled", true);
                    e.preventDefault();
                });

                $(".spinner").removeClass('d-none');
                $("#btn_next-text").text("{{trans('messages.listing_basic.next')}} ..");
                return true;
            }
		});
	});
</script>
@endpush
