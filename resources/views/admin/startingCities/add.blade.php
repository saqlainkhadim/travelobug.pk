@php 
$form_data = [
    'page_title'=> 'Add Staritng City',
    'page_subtitle'=> '', 
    'form_name' => 'Add Staritng City Form',
    'form_id' => 'add_city',
    'action' => URL::to('/').'/admin/settings/add-address',
    'form_type' => 'file',
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => ' Staring City Name', 'name' => 'name', 'value' => ''],
        ['type' => 'hidden', 'id' => 'latitude', 'label' => 'latitude', 'name' => 'latitude', 'value' => ''],
      ['type' => 'hidden', 'id' => 'longitude', 'label' => 'longitude', 'name' => 'longitude', 'value' => ''],
    ]
];
@endphp
@include("admin.common.form.setting", $form_data)

<script src="{{ asset('public/backend/js/additional-method.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/locationpicker.jquery.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {

            $('#add_city').validate({
                rules: {
                    name: {
                        required: true
                    },
                    image: {
                        required: true,
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