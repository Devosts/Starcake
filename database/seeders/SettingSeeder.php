<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'site', 'key' => 'site_name', 'label' => 'Nama Situs', 'type' => 'text', 'value' => 'Star Cake'],
            ['group' => 'site', 'key' => 'site_tagline', 'label' => 'Tagline', 'type' => 'text', 'value' => 'Kue Enak, Hati Senang'],
            ['group' => 'site', 'key' => 'site_logo', 'label' => 'Logo', 'type' => 'image', 'value' => 'images/logo.png'],
            ['group' => 'site', 'key' => 'favicon', 'label' => 'Favicon', 'type' => 'image', 'value' => 'images/logo.png'],

            ['group' => 'contact', 'key' => 'phone', 'label' => 'No. Telepon', 'type' => 'text', 'value' => '0812-3456-7890'],
            ['group' => 'contact', 'key' => 'whatsapp_number', 'label' => 'Nomor WhatsApp', 'type' => 'text', 'value' => '6281234567890'],
            ['group' => 'contact', 'key' => 'email', 'label' => 'Email', 'type' => 'text', 'value' => 'order@starcake.com'],
            ['group' => 'contact', 'key' => 'address', 'label' => 'Alamat', 'type' => 'textarea', 'value' => 'Jl. Kue Indah No. 1, Jakarta 10340'],
            ['group' => 'contact', 'key' => 'operating_hours', 'label' => 'Jam Operasional', 'type' => 'text', 'value' => 'Senin–Minggu, 08.00 – 20.00'],

            ['group' => 'social', 'key' => 'instagram_url', 'label' => 'Instagram', 'type' => 'text', 'value' => 'https://instagram.com/starcake'],
            ['group' => 'social', 'key' => 'facebook_url', 'label' => 'Facebook', 'type' => 'text', 'value' => 'https://facebook.com/starcake'],

            ['group' => 'delivery', 'key' => 'free_delivery_min', 'label' => 'Minimum Gratis Ongkir', 'type' => 'number', 'value' => '150000'],
            ['group' => 'delivery', 'key' => 'delivery_fee', 'label' => 'Biaya Ongkir', 'type' => 'number', 'value' => '15000'],
            ['group' => 'delivery', 'key' => 'tax_rate', 'label' => 'Pajak (%)', 'type' => 'number', 'value' => '0'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                ['group' => $s['group'], 'label' => $s['label'], 'type' => $s['type'], 'value' => $s['value']]
            );
        }

        Setting::flushCache();
    }
}
