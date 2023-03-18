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
							<form id="lis_pricing" method="post" action="{{url('activity/listing/'.$result->id.'/'.$step)}}" accept-charset='UTF-8'>
								{{ csrf_field() }}
								<div class="form-row mt-4 border rounded pb-4 m-0">
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3 pl-4">
											<h4 class="text-16 font-weight-700">{{trans('messages.listing_price.base_price')}}</h4>
									</div>
									<div class="form-group col-lg-6 pl-5 pr-5">
										<label for="listing_price_native" class="label-large">{{trans('messages.listing_price.price_per_person')}} <span class="text-danger">*</span></label>
										<div class="input-addon">
										<span class="input-prefix pay-currency">{!! $result->price->currency->org_symbol !!}</span>
										<input type="text" data-suggested="" id="price-night" value="{{ ($result->price->original_price == 0) ? '' : $result->price->original_price }}" name="price" class="money-input form-control">
										</div>
										<span class="text-danger">{{ $errors->first('price') }}</span>
									</div>

									<div class="form-group col-lg-6 pl-5 pr-5">
										{{-- <label for="inputPassword4">{{trans('messages.listing_price.currency')}}</label>
										<select id='price-select-currency_code' name="currency_code" class='form-control text-16 mt-2'>
											@foreach($currency as $key => $value)
												<option value="{{$key}}" {{$result->property_price->currency_code == $key?'selected':''}}>{{$value}}</option>
											@endforeach
										</select> --}}
										<input type="hidden" name="currency_code" value="PKR">
										{{-- <span class="text-danger" id="price-error">
											<label id="price-night-error" class="error" for="price-night">{{ $errors->first('currency') }}</label>
										</span> --}}
									</div>

									<div class="form-group col-md-12">
										@if($result->price->weekly_discount == 0 && $result->price->monthly_discount == 0)
											<p id="js-set-long-term-prices" class="row-space-top-6 text-center text-muted set-long-term-prices">
											{{trans('messages.listing_price.offer')}}  <a data-prevent-default="" href="#" id="show_long_term">{{trans('messages.listing_price.discounts')}}</a>
											</p>
											<hr class="row-space-top-6 row-space-5 set-long-term-prices">
										@endif
									</div>
								</div>

								<div class="form-row mt-4 border rounded pb-4 m-0  {{ ($result->price->discount == 0)? 'display-off':''}}" id="long-term-div">
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3 pl-4">
										<h4 class="text-16 font-weight-700">{{trans('messages.listing_price.long_term_price')}}</h4>
									</div>

									<div class="col-md-12 pl-5 pr-5">
										<label for="listing_price_native" >
											{{trans('messages.listing_price.week_price')}}
										</label>

										<div class="input-addon">
											<span class="input-prefix pay-currency">{!! $result->price->currency->org_symbol !!}</span>
              								<input type="text" data-suggested="" id="price-week" value="{{ $result->price->weekly_discount }}" name="weekly_discount" data-saving="long_price" class="money-input form-control">
										</div>
									</div>

								</div>




								<div class="row justify-content-between mt-4 mb-5">
									<div class="mt-4">
										<a  data-prevent-default="" href="{{ url('activity/listing/'.$result->id.'/photos') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5">
											{{trans('messages.listing_description.back')}}
										</a>
									</div>

									<div class="mt-4">
										<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i> <span id="btn_next-text">{{trans('messages.listing_basic.next')}}</span>

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
		$(document).on('change', '.pricing_checkbox', function(){
			if(this.checked){
			var name = $(this).attr('data-rel');
			$('#'+name).show();
			}else{
			var name = $(this).attr('data-rel');
			$('#'+name).hide();
			$('#price-'+name).val(0);
			}
		});

		$(document).on('click', '#show_long_term', function(){
			$('#js-set-long-term-prices').hide();
			$('#long-term-div').show();
		});

		$(document).on('change', '#price-select-currency_code', function(){
			var currency = $(this).val();
			var dataURL = '{{url("currency-symbol")}}';
			//console.log(currency);
			$.ajax({
			url: dataURL,
			data: {
					"_token": "{{ csrf_token() }}",
					'currency': currency
				},
			type: 'post',
			dataType: 'json',
			success: function (result) {
				if(result.success == 1)
				$('.pay-currency').html(result.symbol);
			},
			error: function (request, error) {
				// This callback function will trigger on unsuccessful action
				console.log(error);
			}
			});
		});
	</script>

	<script type="text/javascript">
		$(document).ready(function () {
			$('#lis_pricing').validate({
				rules: {
					price: {
						required: true,
						number: true,
						min: 5
					},
					weekly_discount: {
						number: true,
						max: 99,
						min: 0
					},
					monthly_discount: {
						number: true,
						max: 99,
						min: 0
					}
				},
				errorPlacement: function (error, element) {
					console.log('dd', element.attr("name"))
					if (element.attr("name") == "price") {
						error.appendTo("#price-error");
					} else {
						error.insertAfter(element)
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
					price: {
						required:  "{{ __('messages.jquery_validation.required') }}",
						number: "{{ __('messages.jquery_validation.number') }}",
						min: "{{ __('messages.jquery_validation.min5') }}",
					},
					weekly_discount: {
						number: "{{ __('messages.jquery_validation.number') }}",
						max: "{{ __('messages.jquery_validation.max99') }}",
						min: "{{ __('messages.jquery_validation.min0') }}",
					},
					monthly_discount: {
						number: "{{ __('messages.jquery_validation.number') }}",
						max: "{{ __('messages.jquery_validation.max99') }}",
						min: "{{ __('messages.jquery_validation.min0') }}",
					}
				}
			});

		});
	</script>
	@endpush
