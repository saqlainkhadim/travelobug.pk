@php
$form_data = [
		'page_title'=> 'Amenity Edit Form',
		'page_subtitle'=> 'Edit Amenity',
		'form_name' => 'Amenity Edit Form',
		'form_id' => 'edit_amen',
        'form_type' => 'file',
		'action' => route('activity.edit-amenity', $result->id),
		'fields' => [
            ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'title', 'value' => $result->title],
            ['type' => 'textarea', 'class' => '', 'label' => 'Description', 'name' => 'description', 'value' => $result->description],
            ['type' => 'file', 'class' => '', 'label' => 'Symbol Image', 'name' => 'symbol', 'required' => true, 'image' => asset("public/images/symbols/{$result->symbol}")],
            ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => $result->status]
		]
	];
@endphp
@include("admin.common.form.primary", $form_data)

<script type="text/javascript">
    $(document).ready(function () {
            $('#edit_amen').validate({
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
