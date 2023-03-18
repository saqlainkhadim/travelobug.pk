@php
$form_data = [
		'page_title'=> 'Amenitie Add Form',
		'page_subtitle'=> 'Add Amenitie',
		'form_name' => 'Amenitie Add Form',
		'form_id' => 'add_amen',
        'form_type' => 'file',
		'action' => URL::to('/').'/admin/add-amenities',
		'fields' => [
            ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'title', 'value' => ''],
            ['type' => 'textarea', 'class' => 'validate_field', 'label' => 'Description', 'name' => 'description', 'value' => ''],
            ['type' => 'file', 'class' => '', 'label' => 'Symbol', 'name' => 'symbol', 'required' => true],
            ['type' => 'select', 'options' =>$am, 'class' => 'validate_field', 'label' => 'Type', 'name' => 'type_id', 'value' => ''],
            ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => ''],
		]
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
