<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General settings
            [
                'key' => 'site_name',
                'value' => 'Flower Shop',
                'group' => 'general',
                'type' => 'text',
                'label' => 'Tên website',
            ],
            [
                'key' => 'site_description',
                'value' => 'Cửa hàng hoa tươi đẹp nhất',
                'group' => 'general',
                'type' => 'textarea',
                'label' => 'Mô tả website',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'group' => 'general',
                'type' => 'boolean',
                'label' => 'Chế độ bảo trì',
            ],
            [
                'key' => 'allow_registration',
                'value' => '1',
                'group' => 'general',
                'type' => 'boolean',
                'label' => 'Cho phép đăng ký',
            ],
            [
                'key' => 'items_per_page',
                'value' => '12',
                'group' => 'general',
                'type' => 'number',
                'label' => 'Số sản phẩm mỗi trang',
            ],

            // Contact settings
            [
                'key' => 'contact_email',
                'value' => 'admin@flowershop.com',
                'group' => 'contact',
                'type' => 'email',
                'label' => 'Email liên hệ',
            ],
            [
                'key' => 'contact_phone',
                'value' => '0123456789',
                'group' => 'contact',
                'type' => 'text',
                'label' => 'Số điện thoại',
            ],
            [
                'key' => 'address',
                'value' => '123 Nguyễn Văn Linh, Quận 7, TP. HCM',
                'group' => 'contact',
                'type' => 'textarea',
                'label' => 'Địa chỉ',
            ],

            // Social media settings
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/flowershop',
                'group' => 'social',
                'type' => 'url',
                'label' => 'Facebook URL',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/flowershop',
                'group' => 'social',
                'type' => 'url',
                'label' => 'Instagram URL',
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/flowershop',
                'group' => 'social',
                'type' => 'url',
                'label' => 'Twitter URL',
            ],

            // Appearance settings
            [
                'key' => 'dark_mode_default',
                'value' => '0',
                'group' => 'appearance',
                'type' => 'boolean',
                'label' => 'Chế độ tối mặc định',
            ],
            [
                'key' => 'primary_color',
                'value' => '#ec4899',
                'group' => 'appearance',
                'type' => 'color',
                'label' => 'Màu chính',
            ],

            // Store settings
            [
                'key' => 'currency',
                'value' => 'VND',
                'group' => 'store',
                'type' => 'select',
                'label' => 'Đơn vị tiền tệ',
                'options' => json_encode(['VND' => 'VND', 'USD' => 'USD', 'EUR' => 'EUR']),
            ],
            [
                'key' => 'timezone',
                'value' => 'Asia/Ho_Chi_Minh',
                'group' => 'store',
                'type' => 'select',
                'label' => 'Múi giờ',
                'options' => json_encode([
                    'Asia/Ho_Chi_Minh' => 'Việt Nam (UTC+7)',
                    'Asia/Singapore' => 'Singapore (UTC+8)',
                    'Asia/Tokyo' => 'Tokyo (UTC+9)',
                    'UTC' => 'UTC',
                ]),
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
