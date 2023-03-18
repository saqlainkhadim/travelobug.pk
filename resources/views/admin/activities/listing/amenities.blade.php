	@extends('admin.template')
	@section('main')
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content-header">
				<h1>Amenities<small>Amenities</small></h1>
			<ol class="breadcrumb">
				<li><a href="{{url('/')}}/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
			</ol>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-3 settings_bar_gap">
					@include('admin.activities.activity_bar')
				</div>

				<div class="col-md-9">
					<form method="post" action="{{url('admin/activity/listing/'.$result->id.'/'.$step)}}" class='signup-form login-form' accept-charset='UTF-8'>
						{{ csrf_field() }}
						<div class="box box-info">
							<div class="box-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>Activity Amenities</h4>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="row">
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
                                        </div>
                                    </div>
                                </div>
								<br>
								<div class="row">
									<div class="col-md-6 col-sm-6 col-xs-6 text-left">
										<a data-prevent-default="" href="{{ url('admin/activity/listing/'.$result->id.'/location') }}" class="btn btn-large btn-primary">{{trans('messages.listing_description.back')}}</a>
									</div>

									<div class="col-md-6 col-sm-6 col-xs-6 text-right">
										<button type="submit" class="btn btn-large btn-primary next-section-button">
										{{trans('messages.listing_basic.next')}}
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
	</div>
	@stop
