<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Skip in console to speed up commands
        if ($this->app->runningInConsole()) {
            return;
        }

        // Try to load settings from cache or database
        try {
            // Check if settings table exists
            if (\Schema::hasTable('settings')) {
                $this->loadSettings();
                $this->shareSettingsWithViews();
            }
        } catch (\Exception $e) {
            // Log the error but don't crash the application
            \Log::error('Error loading settings: ' . $e->getMessage());
        }
    }

    /**
     * Load settings and apply to config
     */
    private function loadSettings(): void
    {
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $key = $setting->key;
            $value = $setting->value;

            // Store in cache
            Cache::rememberForever("setting.{$key}", function () use ($value) {
                return $value;
            });

            // Apply settings to configuration
            switch ($key) {
                case 'site_name':
                    Config::set('app.name', $value);
                    break;
                case 'site_description':
                    Config::set('app.description', $value);
                    break;
                case 'contact_email':
                    Config::set('mail.from.address', $value);
                    Config::set('mail.from.name', $value);
                    break;
                case 'timezone':
                    Config::set('app.timezone', $value);
                    break;
                case 'items_per_page':
                    Config::set('app.items_per_page', (int) $value);
                    break;
                case 'currency':
                    Config::set('app.currency', $value);
                    break;
            }
        }
    }

    /**
     * Share settings with all views
     */
    private function shareSettingsWithViews(): void
    {
        View::composer('*', function ($view) {
            $settings = [
                'site_name' => SettingsHelper::siteName(),
                'site_description' => SettingsHelper::siteDescription(),
                'dark_mode_default' => SettingsHelper::isDarkModeDefault(),
                'primary_color' => SettingsHelper::primaryColor(),
                'contact_email' => SettingsHelper::contactEmail(),
                'contact_phone' => SettingsHelper::contactPhone(),
                'address' => SettingsHelper::address(),
                'currency' => SettingsHelper::currency(),
                'social_media' => SettingsHelper::socialMedia(),
                'maintenance_mode' => SettingsHelper::isMaintenanceMode(),
                'allow_registration' => SettingsHelper::isRegistrationAllowed(),
            ];

            $view->with('settings', $settings);
        });
    }
}
