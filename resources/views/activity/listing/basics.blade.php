@extends('template', ['title' => "Activity Listing"])
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10">
			<div class="main-panel min-height mt-4">
				<div class="row">
					<div class="col-md-3 pl-4 pr-4">
						@include('activity.listing.sidebar')
					</div>

					<div class="col-md-9  mt-4 mt-sm-0 pl-4 pr-4">
						<form method="post" action="{{url('activity/listing/'.$result->id.'/'.$step)}}"  accept-charset='UTF-8' id="listing_bes">
							{{ csrf_field() }}
							<div class="form-row mt-4 border rounded pb-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3">{{trans('messages.listing_basic.basic_info')}}</h4>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label class="label-large">{{trans('messages.listing_basic.activity_type')}}</label>
									<select name="activity_type" data-saving="basics1" class="form-control">
										@foreach($activity_type as $key => $value)
										  <option value="{{ $key }}" {{ ($key == $result->activity_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label class="label-large">Recomended</label>
									<select name="recomended" id="basics-select-recomended" class="form-control">
										<option value="1" {{ ( $result->recomended == 1) ? 'selected' : '' }}>Yes</option>
										<option value="0" {{ ( $result->recomended == 0) ? 'selected' : '' }}>No</option>
									</select>
								</div>
							</div>

							<div class="form-row float-right mt-5 mb-5">
								<div class="col-md-12 pr-0">
									<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3" id="btn_next"><i class="spinner fa fa-spinner fa-spin d-none" ></i>
										<span id="btn_next-text">{{trans('messages.listing_basic.next')}}</span>
									</button>
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
		$('#listing_bes').validate({
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
