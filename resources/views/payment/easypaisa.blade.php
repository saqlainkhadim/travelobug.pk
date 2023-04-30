@extends('template')
@section('main')
<div class="container-fluid container-fluid-90 margin-top-85 min-height">
    @if (Session::has('message'))
    <div class="row mt-5">
        <div
            class="col-md-12 text-13 alert mb-0 {{ Session::get('alert-class') }} alert-dismissable fade in  text-center opacity-1">
            <a href="#" class="close " data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get('message') }}
        </div>
    </div>
    @endif
    <div class="modal " id="wait-easypay" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-body" style="display:flex">
                    <div>
                        <img src="{{ asset('public/payment-images/easypaisa.png') }}" style="height: 74px;" />
                    </div>

                    <div style="padding:0px 10px; font-weight:600;">
                        Please wait while we are making request to your EasyPaisa Mobile Number.... <br><br>
                        Dial your PIN to your mobile on Popup ( Transaction Rs.
                        <?php echo $post_data['amount']; ?>)

                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-8 col-xs-12 mb-5 main-panel p-5 border rounded">
            <div class="pb-3 m-0 text-24 font-weight-700">EasyPaisa Payment {{ trans('messages.payment.payment') }}
            </div>
            <form action="{{ url('payments/easypaisa') }}" method="post" id="payment-form">
                @csrf


                <table class="table table-borderless">
                    <tr>
                        <td>Mobile AccountNo<span class="danger-text">*</span>:</td>
                    </tr>
                    <tbody>
                        <tr>
                            <?php
                                $phone_no = auth()->user()->formatted_phone;
                                $first_mobileAccountNo_char = substr(auth()->user()->formatted_phone, 0, 1);
                                if (auth()->user()->default_country == 'pk' && $first_mobileAccountNo_char == '+') {
                                    $phone_no = convert_pk_phone_number(auth()->user()->formatted_phone);
                                }

                                ?>
                            <td><input class="form-control" required name="mobileAccountNo" type="text"
                                    value="03164446188">
                                <span class="text-danger">{{ $errors->first('mobileAccountNo') }}</span>
                            </td>
                        </tr>
                    </tbody>
                    <tr>
                        <td>emailAddress<span class="danger-text">*</span>:</td>
                    </tr>
                    <tbody>
                        <tr>
                            <td><input class="form-control" required name="emailAddress" type="email"
                                    value="{{ auth()->user()->email }}">
                                <span class="text-danger">{{ $errors->first('emailAddress') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-row p-0 m-0">
                    <label for="card-element">
                        you are going to pay Rs.
                        <?php echo $post_data['amount']; ?> though Easypaisa
                    </label>
                </div>
                <div class="form-group mt-5">
                    <div class="col-sm-8 p-0">
                        <button type="submit"
                            class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3"><i
                                class="spinner fa fa-spinner fa-spin d-none"></i>Pay</button>
                    </div>
                </div>
            </form>

        </div>
@if(request('category') == 'activity')
        @php
        $price = ($category == 'activity' ? $result->price : $result->property_price);
        $address = ($category == 'activity' ? $result->address : $result->property_address);
        @endphp

        <div class="col-md-4  mt-3 mb-5">
            <div class="card p-3">
                <a href="{{ url('/') }}/activities/{{ $result->slug}}">
                    <img class="card-img-top p-2 rounded" src="{{ $result->cover_photo }}" alt="{{ $result->name }}"
                        height="180px">
                </a>

                <div class="card-body p-2">
                    <a href="{{ url('/') }}/activities/{{ $result->slug}}">
                        <p class="text-16 font-weight-700 mb-0">{{ $result->name }}</p>
                    </a>

                    <p class="text-14 mt-2 text-muted mb-0">
                        <i class="fas fa-map-marker-alt"></i>
                        {{$address->address_line_1}}, {{ $address->state }}, {{ $address->country_name }}
                    </p>
                    <div class="border p-4 mt-4 text-center rounded-3">
                        <p class="text-16 mb-0">
                            <strong class="font-weight-700 secondary-text-color">{{ $result->property_type_name
                                }}</strong>
                            {{trans('messages.payment.for')}}
                            <strong class="font-weight-700 secondary-text-color">{{ $number_of_guests }}
                                {{trans('messages.payment.guest')}}</strong>
                        </p>
                        <div class="text-16"><strong>{{ date('D, M d, Y', strtotime($checkin)) }}</strong> to <strong>{{
                                date('D, M d, Y', strtotime($checkout)) }}</strong></div>
                    </div>

                    <div class="border p-4 rounded-3 mt-4">

                        @foreach( $price_list->date_with_price as $date_price)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ $date_price->date }}</p>
                            </div>
                            <div>
                                <p class="pr-4">{!! $date_price->price !!}</p>
                            </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4 text-capitalize">{{ trans('messages.activity_single.person') }}</p>
                            </div>
                            <div>
                                <p class="pr-4">{{ $price_list->total_persons }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{!! $price_list->per_day_price_with_symbol !!} x {{
                                    $price_list->total_days }} day</p>
                            </div>
                            <div>
                                <p class="pr-4">{!! $price_list->total_day_price_with_symbol !!}</p>
                            </div>
                        </div>

                        @if($price_list->service_fee)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{trans('messages.payment.service_fee')}}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        {{-- @if($price_list->additional_guest)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{trans('messages.payment.additional_guest_fee')}}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif --}}

                        <hr>

                        <div class="d-flex justify-content-between font-weight-700">
                            <div>
                                <p class="pl-4">{{trans('messages.payment.total')}}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="exfont text-16">
                        {{trans('messages.payment.paying_in')}}
                        <strong><span id="payment-currency">{!!
                                moneyFormat($currencyDefault->org_symbol,$currencyDefault->code) !!}</span></strong>.
                        {{trans('messages.payment.your_total_charge')}}
                        <strong><span id="payment-total-charge">{!! moneyFormat($currencyDefault->org_symbol,
                                $price_eur) !!}</span></strong>.
                        {{-- {{trans('messages.payment.exchange_rate_booking')}} {!!
                        moneyFormat($currentCurrency->symbol, 1) !!} {!! $currentCurrency->code !!} to {!!
                        moneyFormat($price->currency->org_symbol, $price_rate ) !!} {{ $price->currency_code }} (
                        {{trans('messages.listing_book.host_currency')}} ). --}}
                    </p>
                </div>
            </div>


        </div>
@else

        {{-- <div class="col-md-4 mb-5">
            <div class="card p-3">
                <a href="{{ url('/') }}/properties/{{ $result->slug }}">
                    <img class="card-img-top p-2 rounded" src="{{ $result->cover_photo }}" alt="{{ $result->name }}"
                        height="180px">
                </a>
                <div class="card-body p-2">
                    <a href="{{ url('/') }}/properties/{{ $result->slug }}">
                        <p class="text-16 font-weight-700 mb-0">{{ $result->name }}</p>
                    </a>

                    <p class="text-14 mt-2 text-muted mb-0">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $result->property_address->address_line_1 ?? '' }}, {{ $result->property_address->state?? ''
                        }},
                        {{ $result->property_address->country_name?? '' }}
                    </p>
                    <div class="border p-4 mt-4 text-center">
                        <p class="text-16 mb-0">
                            <strong class="font-weight-700 secondary-text-color">{{ $result->property_type_name
                                }}</strong>
                            {{ trans('messages.payment.for') }}
                            <strong class="font-weight-700 secondary-text-color">{{ $number_of_guests }}
                                {{ trans('messages.payment.guest') }}</strong>
                        </p>
                        <div class="text-14"><strong>{{ date('D, M d, Y', strtotime($checkin)) }}</strong> to
                            <strong>{{ date('D, M d, Y', strtotime($checkout)) }}</strong>
                        </div>
                    </div>

                    <div class="border p-4 mt-3">

                        @foreach ($price_list->date_with_price as $date_price)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ $date_price->date }}</p>
                            </div>
                            <div>
                                <p class="pr-4">{!! $date_price->price !!}</p>
                            </div>
                        </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.night') }}</p>
                            </div>
                            <div>
                                <p class="pr-4">{{ $nights }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{!! $price_list->per_night_price_with_symbol ?? '' !!} x {{ $nights }}
                                    {{ trans('messages.payment.nights') }}</p>
                            </div>
                            <div>
                                <p class="pr-4">{!! $price_list->total_night_price_with_symbol ?? '' !!}</p>
                            </div>
                        </div>

                        @if ($price_list->service_fee)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.service_fee') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->service_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        @if (isset($price_list->additional_guest) )
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.additional_guest_fee') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->additional_guest_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        @if ($price_list->security_fee)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.security_deposit') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->security_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        @if ($price_list->cleaning_fee)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.cleaning_fee') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->cleaning_fee_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        @if ($price_list->iva_tax)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.property_single.iva_tax') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->iva_tax_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif

                        @if ($price_list->accomodation_tax)
                        <div class="d-flex justify-content-between text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.property_single.accommodatiton_tax') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->accomodation_tax_with_symbol !!}</p>
                            </div>
                        </div>
                        @endif
                        <hr>

                        <div class="d-flex justify-content-between font-weight-700 text-16">
                            <div>
                                <p class="pl-4">{{ trans('messages.payment.total') }}</p>
                            </div>

                            <div>
                                <p class="pr-4">{!! $price_list->total_with_symbol !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body text-16">
                    <p class="exfont">
                        {{ trans('messages.payment.paying_in') }}
                        <strong><span id="payment-currency">{!! moneyFormat($currencyDefault->symbol,
                                $currencyDefault->code) !!}</span></strong>.
                        {{ trans('messages.payment.your_total_charge') }}
                        <strong><span id="payment-total-charge">{!! moneyFormat($currencyDefault->org_symbol,
                                $price_eur) !!}</span></strong>.
                        {{ trans('messages.payment.exchange_rate_booking') }} {!! $symbol !!} 1 to
                        {!! moneyFormat($price_list->property_default->symbol,
                        $price_list->property_default->local_to_propertyRate) !!} {!!
                        $price_list->property_default->currency_code !!} (
                        {{ trans('messages.listing_book.host_currency') }} ).
                    </p>
                </div>
            </div>


        </div> --}}
@endif
    </div>
</div>
@push('scripts')
@if (Request::path() == 'payments/stripe')
<script src="https://js.stripe.com/v3/"></script>
@endif
<script type="text/javascript" src="{{ url('public/js/jquery.validate.min.js') }}"></script>
<script></script>
<script type="text/javascript">
    $(document).ready(function() {
                $("form").on('submit', function(e) {
                    $('#wait-easypay').modal('show');

                    e.preventDefault();
                    let form_url = this.action;
                    let form_data = $(this).serialize();


                    $.ajax({
                            url: form_url,
                            method: "POST",
                            dataType: "json",
                            data: form_data,
                            // beforeSend:function(result){
                            //     alert('beforeSend');
                            // },
                            success: function(response){

                                ajaxSuccessToastr(response);
                                $('#wait-easypay').modal('hide');
                                window.location = response.data.redirect_url;
                            },
                            error: function(data){
                                ajaxErrorToastr(data);
                                $('#wait-easypay').modal('hide');
                            },

                        });


                });
            });
</script>

@endpush
@stop
