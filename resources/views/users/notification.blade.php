@extends('template', ['title' => "Notification"])
@push('css')
<style>
    .vbtn-outline-success:hover {
        background: var(--scheme-color) !important;
    }

    .btn-outline-danger:hover {
        background: #dc3545 !important;
    }
</style>
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
                                <span class="text-18 pt-4 pb-4 font-weight-700">
                                    Notification
                                </span>
                            </div>
                        </div>
                    </div>
                    @if(Session::has('message'))
                    <div class="alert alert-success text-center" role="alert" id="alert">
                        <span id="messages">{{ Session::get('message') }}</span>
                    </div>
                    @endif
                    @if (count($notifications))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>@lang('Message')</th>
                                <th width='150'>@lang('Created At')</th>
                                <th width='130'>@lang('Action')</th>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->message }}</td>
                                    <td>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        @if ($notification->status == 'unread')
                                        <a href="{{ route('user.notification.read',$notification->id) }}" class="btn btn-info">@lang('Read')</a>
                                        @endif
                                        <a href="{{ route('user.notification.delete', $notification->id) }}" class="btn btn-danger">@lang('Delete')</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="row jutify-content-center position-center w-100 p-4 mt-4 ">
                        <div class="text-center w-100">
                            <img src="{{ url('public/img/unnamed.png')}}" alt="notfound" class="img-fluid">
                            <p class="text-center"> You don't have any notification.</p>
                        </div>
                    </div>
                    @endif

                    <div class="row justify-content-between overflow-auto pb-3 mt-4 mb-5">
                        {{ $notifications->links('paginate')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script src="{{ url('public/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $(document).on('change', '#trip_select', function(){

            $("#my-trip-form").trigger("submit");

        });

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
                                    $(that).css('color', 'forestgreen');
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
</script>

@endpush
