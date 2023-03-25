<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class NewPaymentMethodSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Settings for easy paisa
        Settings::create(
            [
                'name' => 'store_id',
                'type' => 'easypaisa',
                'value' => 'empty'
            ]
        );
        Settings::create([
            'name' => 'hash_key',
            'type' => 'easypaisa',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'post_url',
            'type' => 'easypaisa',
            'value' => 'empty'
        ]);

        Settings::create([
            'name' => 'confirm_url',
            'type' => 'easypaisa',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'payment_method',
            'type' => 'easypaisa',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'easypaisa_status',
            'type' => 'easypaisa',
            'value' => 'empty'
        ]);



//        Settings for JazzCash
        Settings::create([
            'name' => 'merchant_id',
            'type' => 'jazzcash',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'password',
            'type' => 'jazzcash',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'post_url',
            'type' => 'jazzcash',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'integerity_salt',
            'type' => 'jazzcash',
            'value' => 'empty'
        ]);
        Settings::create([
            'name' => 'jazzcash_status',
            'type' => 'jazzcash',
            'value' => 'empty'
        ]);
    }
}
