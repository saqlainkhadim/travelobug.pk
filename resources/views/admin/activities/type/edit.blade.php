@php
$form_data = [
    'page_title' => 'Edit Activity Type',
    'page_subtitle' => '',
    'form_name' => 'Edit Activity Type Form',
    'form_id' => 'edit_activity',
    'action' => URL::to('/') . '/admin/settings/edit-activity-type/' . $result->id,
    'fields' => [
        ['type' => 'text', 'class' => '', 'label' => 'Name', 'name' => 'name', 'value' => $result->name],
        ['type' => 'textarea', 'class' => '', 'label' => 'Description', 'name' => 'description', 'value' => $result->description],
        ['type' => 'select', 'options' => ['Active' => 'Active', 'Inactive' => 'Inactive'], 'class' => 'validate_field', 'label' => 'Status', 'name' => 'status', 'value' => $result->status]
    ],
];
@endphp
@include('admin.common.form.setting', $form_data)

<script type="text/javascript">
    $(document).ready(function() {

        $('#edit_activity').validate({
            rules: {
                name: {
                    required: true
                },
                description: {
                    required: true
                }
            }
        });

    });
</script>
