@extends('template', ['title' => "Activity Listing"])

@section('main')
<div class="margin-top-85">
    <div class="row m-0">
        @include('users.sidebar')

        <div class="col-lg-10">
            <div class="main-panel">
                <div class="container-fluid min-height">
                    <div class="row">
                        <div class="col-md-12 p-0 mb-3">
                            <div class="list-bacground mt-4 rounded-3 p-4 border">
                                <span class="text-18 pt-4 pb-4 font-weight-700">{{trans('messages.listing_basic.listing')}}</span>

                                <div class="float-right">
                                    <div class="d-flex">
                                        <div class="pr-4">
                                            <a href="{{ route('user.activity.add') }}" class="btn btn-lg btn-outline-violet">{{ __('Add Activities') }}</a>
                                        </div>

                                        <div class="pr-4">
                                            <span class="text-14 pt-2 pb-2 font-weight-700">{{trans('messages.users_dashboard.sort_by')}}</span>
                                        </div>

                                        <div>
                                            <form action="{{ url('/activities') }}" method="POST" id="listing-form">
                                                {{ csrf_field() }}
                                                <select class="form-control text-center text-14 minus-mt-6" id="listing_select" name="status">
                                                    <option value="All" {{ @$status == "All" ? ' selected="selected"' : '' }}>{{trans('messages.filter.all')}}</option>
                                                    <option value="Listed" {{ @$status == "Listed" ? ' selected="selected"' : '' }}>{{trans('messages.property.listed')}}</option>
                                                    <option value="Unlisted" {{ @$status == "Unlisted" ? ' selected="selected"' : '' }}>{{trans('messages.property.unlisted')}}</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success d-none" role="alert" id="alert">
                        <span id="messages"></span>
                    </div>

                    <div id="products" class="row mt-3">
                        @forelse($activities as $activity)
                            <div class="col-md-12 p-0 mb-4">
                                <div class=" row  border p-2 rounded-3">
                                    <div class="col-md-3 col-xl-4 p-2">
                                        <div class="img-event">
                                            <a href="activities/{{ $activity->slug }}">
                                                <img class="room-image-container200 rounded" src="{{ $activity->cover_photo }}" alt="cover_photo">
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-6 p-2">
                                        <div>
                                            <a href="activities/{{ $activity->slug }}">
                                                <p class="mb-0 text-18 text-color font-weight-700 text-color-hover">{{ ($activity->name == '') ? '' : $activity->name }}</p>
                                            </a>
                                        </div>

                                        <p class="text-14 mt-3 text-muted mb-0">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{$activity->address->address_line_1}}
                                        </p>

                                        <div class="review-0 mt-4">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span><i class="fa fa-star text-14 secondary-text-color"></i>
                                                        @php
                                                            $review = $activity->reviews_count;
                                                        @endphp
                                                        @if($review)
                                                            {{ $activity->avg_rating }}
                                                        @else
                                                            0
                                                        @endif
                                                        ({{ $review }})
                                                    </span>
                                                </div>

                                                <div class="pr-5">
                                                    <span class="font-weight-700 text-20">{!! moneyFormat( $currentCurrency->symbol, $activity->price->price) !!}</span> / {{trans('messages.activity.person')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-xl-2">
                                        <div class="d-flex w-100 h-100  mt-3 mt-sm-0 p-2">
                                            <div class="align-self-center w-100">
                                                <div class="row">
                                                    <div class="col-6 col-sm-12">
                                                        <div class="main-toggle-switch text-left text-sm-center">
                                                        @if($activity->steps_completed == 0)
                                                            <div class="mb-3">
                                                                @if ($activity->approved == 1)
                                                                <span class="badge badge-success p-3 pl-4 pr-4 text-14 border-r-25">Approved and Live</span>
                                                                @elseif ($activity->approved == 0)
                                                                <span class="badge badge-info p-3 pl-4 pr-4 text-14 border-r-25">Under Review</span>
                                                                @else
                                                                <span class="badge badge-danger p-3 pl-4 pr-4 text-14 border-r-25">Rejected</span>
                                                                @endif
                                                            </div>
                                                            @if ($activity->approved == 1)
                                                            <label class="toggleSwitch large" onclick="">
                                                                <input type="checkbox" id="status" data-id="{{ $activity->id}}" data-status="{{$activity->status}}"  {{ $activity->status == "Listed" ? 'checked' : '' }}/>
                                                                <span>
                                                                    <span>{{trans('messages.property.unlisted')}}</span>
                                                                    <span>{{trans('messages.property.listed')}}</span>
                                                                </span>
                                                                <a href="#" aria-label="toggle"></a>
                                                            </label>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-warning p-3 pl-4 pr-4 text-14 border-r-25">{{ $activity->steps_completed }} {{trans('messages.property.step_listed')}}</span>
                                                        @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-sm-12">
                                                        <a href="{{ url('activity/listing/'.$activity->id.'/basics') }}">
                                                            <div class="text-color text-color-hover text-14 text-right text-sm-center mt-0 mt-md-3 p-2">
                                                                <i class="fas fa-edit"></i>
                                                                {{trans('messages.property.manage_list_cal')}}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="row jutify-content-center position-center w-100 p-4 mt-4">
                                <div class="text-center w-100">
                                    <img src="{{ url('public/img/unnamed.png')}}" class="img-fluid"   alt="Not Found">
                                    <p class="text-center">{{trans('messages.message.empty_listing')}}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="row justify-content-between overflow-auto  pb-3 mt-4 mb-5">
                        {{ $activities->appends(request()->except('page'))->links('paginate')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
<script type="text/javascript">
    $(document).on('click', '#status', function(){
        var id = $(this).attr('data-id');
        var datastatus = $(this).attr('data-status');
        var dataURL = APP_URL+'/activity/listing/update_status';
        $('#messages').empty();
        $.ajax({
            url: dataURL,
            data:{
                "_token": "{{ csrf_token() }}",
                'id':id,
                'status':datastatus,
            },
            type: 'post',
            dataType: 'json',
            success: function(data) {
                $("#status").attr('data-status', data.status)
                $("#messages").append("");
                $("#alert").removeClass('d-none');
                $("#messages").append(data.name+" "+"has been"+" "+data.status+".");
                var header = $('#alert');
                setTimeout(function() {
                    header.addClass('d-none');
                }, 4000);
            }
        });
    });

     $(document).on('change', '#listing_select', function(){

            $("#listing-form").trigger("submit");

    });
</script>
@endpush


