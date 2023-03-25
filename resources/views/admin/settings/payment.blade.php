@php
$form_data = [
	'page_title'=> 'Payment Setting Form',
	'page_subtitle'=> 'Payment Setting Page',
	'tab_names' => ['paypal' => 'Paypal', 'stripe' => 'Stripe', 'easypaisa' => 'EasyPaisa','jazzcash' => 'JazzCash', 'banks'=> 'Banks'],
	'tab_forms' => [
		'paypal' => [
			'action' => URL::to('/').'/admin/settings/payment-methods',
			'form_class' => 'form-submit-jquery',
			'form_id' => 'pay_form',
			'fields' => [
				['type' => 'hidden', 'class' => '', 'label' => '', 'id' =>'paypal', 'name' => 'gateway', 'value' => 'paypal'],
				['type' => 'text', 'class' => 'validate_field', 'label' => 'PayPal Username', 'name' => 'username', 'value' => $paypal['username']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'PayPal Password', 'name' => 'password', 'value' => $paypal['password']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'PayPal Signature', 'name' => 'signature', 'value' => $paypal['signature']],
	      		['type' => 'select', 'options' => ['sandbox' => 'Sandbox', 'live' => 'Live'], 'class' => 'validate_field', 'label' => 'PayPal Mode', 'name' => 'mode', 'value' => $paypal['mode']],
	      		['type' => 'select', 'options' => ['0' => 'Inactive', '1' => 'Active'], 'class' => 'validate_field', 'label' => 'Paypal Status', 'name' => 'paypal_status', 'value' => $paypal['paypal_status']],
			]
		],
		'stripe' => [
			'action' => URL::to('/').'/admin/settings/payment-methods',
			'form_class' => 'form-submit-jquery',
			'fields' => [
				['type' => 'hidden', 'class' => '', 'label' => '', 'id' =>'stripe', 'name' => 'gateway', 'value' => 'stripe'],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'Stripe Secret Key', 'name' => 'secret_key', 'value' => $stripe['secret']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'Stripe Publishable Key', 'name' => 'publishable_key', 'value' => $stripe['publishable']],
	      		['type' => 'select', 'options' => ['0' => 'Inactive', '1' => 'Active'], 'class' => 'validate_field', 'label' => 'Stripe Status', 'name' => 'stripe_status', 'value' => $stripe['stripe_status']],
			]
		],

		'easypaisa' => [
			'action' => URL::to('/').'/admin/settings/payment-methods',
			'form_class' => 'form-submit-jquery',
			'fields' => [
				['type' => 'hidden', 'class' => '', 'label' => '', 'id' =>'stripe', 'name' => 'gateway', 'value' => 'easypaisa'],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'EASYPAISA STORE ID', 'name' => 'store_id', 'value' => $easypaisa['store_id']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'EASYPAISA HASH KEY', 'name' => 'hash_key', 'value' => $easypaisa['hash_key']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'EASYPAISA POST URL', 'name' => 'post_url', 'value' => $easypaisa['post_url']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'EASYPAISA Confirm URL', 'name' => 'confirm_url', 'value' => $easypaisa['confirm_url']],
	      		['type' => 'select', 'options' => ['0' => 'Inactive', '1' => 'Active'], 'class' => 'validate_field', 'label' => 'EASYPAISA Status', 'name' => 'easypaisa_status', 'value' => $easypaisa['easypaisa_status']],
			]
		],
		'jazzcash' => [
			'action' => URL::to('/').'/admin/settings/payment-methods',
			'form_class' => 'form-submit-jquery',
			'fields' => [
				['type' => 'hidden', 'class' => '', 'label' => '', 'id' =>'stripe', 'name' => 'gateway', 'value' => 'jazzcash'],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'JAZZCASH MERCHANT ID', 'name' => 'merchant_id', 'value' => $jazzcash['merchant_id']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'JAZZCASH PASSWORD', 'name' => 'password', 'value' => $jazzcash['password']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'JAZZCASH POST URL', 'name' => 'post_url', 'value' => $jazzcash['post_url']],
	      		['type' => 'text', 'class' => 'validate_field', 'label' => 'JAZZCASH INTEGERITY SALT', 'name' => 'integerity_salt', 'value' => $jazzcash['integerity_salt']],
	      		['type' => 'select', 'options' => ['0' => 'Inactive', '1' => 'Active'], 'class' => 'validate_field', 'label' => 'JAZZCASH Status', 'name' => 'jazzcash_status', 'value' => $easypaisa['easypaisa_status']],
			]
		],
		'banks' => true,
	]
];
@endphp

@include("admin.common.form.setting-multi-tab", $form_data)


