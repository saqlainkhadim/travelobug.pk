@extends('admin.template')
@section('main')
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
          Location
          <small>Location</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="{{url('/')}}/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a>
        </li>
      </ol>
  </section>
  <section class="content">
    <div class="col-md-3 settings_bar_gap">
      @include('admin.common.property_bar')
    </div>

    <div class="col-md-9">
    <form id="listing_location" method="post" action="{{url('admin/listing/'.$result->id.'/'.$step)}}" class='signup-form login-form'>
      {{ csrf_field() }}
      <div class="box box-info">
      <div class="box-body">
        <input type="hidden" name='latitude' id='latitude'>
        <input type="hidden" name='longitude' id='longitude'>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.country')}} <span class="text-danger">*</span></label>
            <select id="basics-select-bed_type" name="country" class="form-control" id='country'>
                @foreach($country as $key => $value)
                  <option value="{{ $key }}" {{ ($key == $result->property_address->country) ? 'selected' : '' }}>{{ $value }}</option>
                @endforeach
            </select>
            <span class="text-danger">{{ $errors->first('country') }}</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.address_line_1')}} <span class="text-danger">*</span></label>
            <input type="text" name="address_line_1" id="address_line_1" value="{{ $result->property_address->address_line_1  }}" class="form-control" placeholder="House name/number + street/road">
            <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
          </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-8">
                <input type="hidden" name="embeded_map" id="embeded_map_input">
                <textarea id="embeded_map_textarea" class="form-control" placeholder="Embeded Map iframe Code" rows="6">{!! base64_decode($result->embeded_map) !!}</textarea>
                <span class="text-danger">{{ $errors->first('embeded_map') }}</span>
            </div>
            <div class="col-md-12 mt-4 pl-5 pr-5">
                <p class="small text-secondary">N.B: Don't input malicious code here!</p>
            </div>
        </div>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.address_line_2')}}</label>
            <input type="text" name="address_line_2" id="address_line_2" value="{{ $result->property_address->address_line_2  }}" class="form-control" placeholder="Apt., suite, building access code">
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.city_town_district')}} <span class="text-danger">*</span></label>
            <input type="text" name="city" id="city" value="{{ $result->property_address->city  }}" class="form-control">
            <span class="text-danger">{{ $errors->first('city') }}</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.state_province')}} <span class="text-danger">*</span></label>
            <input type="text" name="state" id="state" value="{{ $result->property_address->state  }}" class="form-control">
            <span class="text-danger">{{ $errors->first('state') }}</span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-8 mb20">
            <label class="label-large">{{trans('messages.listing_location.zip_postal_code')}}</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ $result->property_address->postal_code }}" class="form-control">
            <span class="text-danger">{{ $errors->first('postal_code') }}</span>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6 col-xs-6 text-left">
              <a data-prevent-default="" href="{{ url('admin/listing/'.$result->id.'/description') }}" class="btn btn-large btn-primary">{{trans('messages.listing_description.back')}}</a>
          </div>
          <div class="col-md-6 col-xs-6 text-right">
            <button type="submit" class="btn btn-large btn-primary next-section-button" id="listing_location_btn_sub">
             {{trans('messages.listing_basic.next')}}
            </button>
          </div>
        </div>

        </div>
        </div>
    </form>
    </div>
  </section>
   <div class="clearfix"></div>
  </div>

  @stop

  @push('scripts')
    {{-- <script type="text/javascript">
      function updateControls(addressComponents) {
          $('#street_number').val(addressComponents.streetNumber);
          $('#route').val(addressComponents.streetName);
          $('#city').val(addressComponents.city);
          $('#state').val(addressComponents.stateOrProvince);
          $('#postal_code').val(addressComponents.postalCode);
          $('#country').val(addressComponents.country);
      }

      $('#map_view').locationpicker({
          location: {
              latitude: {{$result->property_address->latitude != ''? $result->property_address->latitude:0 }},
              longitude: {{$result->property_address->longitude != ''? $result->property_address->longitude:0 }}
          },
          radius: 0,
          addressFormat: "",
          inputBinding: {
              latitudeInput: $('#latitude'),
              longitudeInput: $('#longitude'),
              locationNameInput: $('#address_line_1_')
          },
          enableAutocomplete: true,
          onchanged: function (currentLocation, radius, isMarkerDropped) {
              var addressComponents = $(this).locationpicker('map').location.addressComponents;
              updateControls(addressComponents);
          },
          oninitialized: function (component) {
              var addressComponents = $(component).locationpicker('map').location.addressComponents;
              updateControls(addressComponents);
          }
      });
    </script> --}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/codemirror.min.js"></script>--}}
    <script>
        {{-- var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('embeded_map'), {
            lineWrapping:true,
            lineNumbers: true,
            mode: "htmlmixed",
            value: "{!! $result->embeded_map !!}"
        ); --}}
        $('#listing_location_btn_sub').on('click', function(e) {
            e.preventDefault();
            const embeded_map_input=$('#embeded_map_input');
            const embeded_map_textarea=$('#embeded_map_textarea');
            const code = embeded_map_textarea.val();
            embeded_map_input.val(btoa(code));
            $('#listing_location').trigger('submit');
            // console.log(embeded_map_input.val());
            // console.log($('#listing_location').serializeArray())
        });
    </script>
  @endpush

@section('validate_script')
<script type="text/javascript">
   $(document).ready(function () {
        $('#listing_location').validate({
            rules: {
                country: {
                    required: true
                },
                address_line_1: {
                    required: true
                },
                address_line_2: {
                    maxlength: 255
                },
                city: {
                    required: true
                },
                state: {
                    required: true
                },
                embeded_map: {
                    required: false
                }
            }
        });
    });
</script>
@endsection

@push('css')
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.9/codemirror.min.css">--}}
{{--    <style>--}}
{{--        .CodeMirror{ border: 1px solid #ddd; } --}}
{{--    </style>--}}
@endpush
