@php 
$form_data = [
    'page_title'=> 'Edit Staritng City',
    'page_subtitle'=> '', 
    'form_name' => 'Edit Staritng City Form',
    'form_id' => 'edit_staritng_city',     
    'action' => URL::to('/').'/admin/settings/edit-address/'.$result->id,
    'form_type' => 'file',
    'fields' => [
      ['type' => 'text','id' => 'map_address', 'class' => '', 'label' => ' Staring City Name', 'name' => 'name', 'value' => $result->name],
      ['type' => 'hidden', 'id' => 'latitude', 'label' => 'latitude', 'name' => 'latitude', 'value' => $result->latitude],
      ['type' => 'hidden', 'id' => 'longitude', 'label' => 'longitude', 'name' => 'longitude', 'value' => $result->longitude],
    ]
  ];
@endphp
@include("admin.common.form.setting", $form_data)


<script src="{{ asset('public/backend/js/additional-method.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/locationpicker.jquery.min.js') }}"></script>

<script type="text/javascript">
   $(document).ready(function () {

            $('#edit_staritng_city').validate({
                rules: {
                    name: {
                        required: true
                    },
                    image: {
                        
                        //extension: "jpg|png|jpeg"
                        accept: "image/jpg,image/jpeg,image/png"
                    }
                },
                messages: {
                    image: {
                        accept: 'The file must be an image (jpg, jpeg or png)'
                    }
                }
            });

        });
        $('#us3').locationpicker({
                location: {
                    latitude: 0,
                    longitude: 0
                },
                radius: 0,
                addressFormat: "",
                inputBinding: {
                    latitudeInput: $('#latitude'),
                    longitudeInput: $('#longitude'),
                    locationNameInput: $('#map_address')
                },
                enableAutocomplete: true,
                onchanged: function(currentLocation, radius, isMarkerDropped) {
                    var addressComponents = $(this).locationpicker('map').location.addressComponents;
                    console.log(addressComponents);
                    updateControls(addressComponents);
                },
                oninitialized: function(component) {
                    var addressComponents = $(component).locationpicker('map').location.addressComponents;
                    updateControls(addressComponents);
                }
            });
</script>