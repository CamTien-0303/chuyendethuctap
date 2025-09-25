<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    /**
     * Get a setting value with caching
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 60 * 60 * 24, function () use ($key, $default) {
            return Setting::getValue($key, $default);
        });
    }

    /**
     * Set a setting value and update cache
     */
    public static function set(string $key, $value, string $group = 'general')
    {
        $setting = Setting::setValue($key, $value, $group);
        Cache::put("setting.{$key}", $value, 60 * 60 * 24);
        return $setting;
    }

    /**
     * Get all settings as an array
     */
    public static function all(): array
    {
        return Cache::remember('settings.all', 60 * 60 * 24, function () {
            return Setting::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('settings.all');
        $keys = Setting::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }

    /**
     * Get boolean setting value
     */
    public static function getBool(string $key, bool $default = false): bool
    {
        $value = self::get($key, $default);
        return in_array($value, [true, 1, '1', 'true', 'on', 'yes'], true);
    }

    /**
     * Get site name
     */
    public static function siteName(): string
    {
        return self::get('site_name', 'Flower Shop');
    }

    /**
     * Get site description
     */
    public static function siteDescription(): string
    {
        return self::get('site_description', 'Cửa hàng hoa tươi đẹp nhất');
    }

    /**
     * Check if dark mode is default
     */
    public static function isDarkModeDefault(): bool
    {
        return self::getBool('dark_mode_default', false);
    }

    /**
     * Get primary color
     */
    public static function primaryColor(): string
    {
        return self::get('primary_color', '#3B82F6');
    }

    /**
     * Get contact email
     */
    public static function contactEmail(): string
    {
        return self::get('contact_email', 'admin@flowershop.com');
    }

    /**
     * Get contact phone
     */
    public static function contactPhone(): string
    {
        return self::get('contact_phone', '');
    }

    /**
     * Get address
     */
    public static function address(): string
    {
        return self::get('address', '');
    }

    /**
     * Get currency
     */
    public static function currency(): string
    {
        return self::get('currency', 'VND');
    }

    /**
     * Get items per page
     */
    public static function itemsPerPage(): int
    {
        return (int) self::get('items_per_page', 12);
    }

    /**
     * Check if maintenance mode is enabled
     */
    public static function isMaintenanceMode(): bool
    {
        return self::getBool('maintenance_mode', false);
    }

    /**
     * Check if registration is allowed
     */
    public static function isRegistrationAllowed(): bool
    {
        return self::getBool('allow_registration', true);
    }

    /**
     * Get social media URLs
     */
    public static function socialMedia(): array
    {
        return [
            'facebook' => self::get('facebook_url', ''),
            'instagram' => self::get('instagram_url', ''),
            'twitter' => self::get('twitter_url', ''),
        ];
    }
}