@php
$form_data = [
		'page_title'=> 'Activity Amenity Add Form',
		'page_subtitle'=> 'Add Activity Amenity',
		'form_name' => 'Activity Amenity Add Form',
		'form_id' => 'add_amen',
        'form_type' => 'file',
		'action' => route('activity.add-amenity'),
		'fields' => [
            ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'title', 'value' => ''],
            ['type' => 'textarea', 'class' => 'validate_field', 'label' => 'Description', 'name' => 'description', 'value' => ''],
            ['type' => 'file', 'class' => '', 'label' => 'Symbol Image', 'name' => 'symbol', 'required' => true],
            ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => ''],
        ],
        'back_uri' => route('activity.amenities')
	];
@endphp
@include("admin.common.form.primary", $form_data)

<script type="text/javascript">
    $(document).ready(function () {
            $('#add_amen').validate({
                rules: {
                    title: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                    symbol: {
                        required: true
                    }
                }
            });
        });
</script>
