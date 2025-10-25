<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Helpers\SettingsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        // Organize settings for the view
        $generalSettings = $settings->get('general', collect());
        $contactSettings = $settings->get('contact', collect());
        $socialSettings = $settings->get('social', collect());
        $appearanceSettings = $settings->get('appearance', collect());
        $storeSettings = $settings->get('store', collect());

        return view('admin.settings.index', compact(
            'generalSettings',
            'contactSettings',
            'socialSettings',
            'appearanceSettings',
            'storeSettings'
        ));
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token', '_method');

        foreach ($inputs as $key => $value) {
            // Handle boolean values from checkboxes
            if (is_null($value)) {
                $value = '0'; // Checkbox not checked
            } elseif (is_string($value) && ($value === 'on' || $value === 'off')) {
                $value = ($value === 'on') ? '1' : '0';
            }

            // Get the setting and update it
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();

                // Update cache using helper
                Cache::put("setting.{$key}", $value, 60 * 60 * 24);

                // Update config for important settings
                switch ($key) {
                    case 'site_name':
                        Config::set('app.name', $value);
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

        // Handle unchecked checkboxes (they don't get submitted)
        $booleanSettings = Setting::where('type', 'boolean')->pluck('key');
        foreach ($booleanSettings as $key) {
            if (!array_key_exists($key, $inputs)) {
                $setting = Setting::where('key', $key)->first();
                if ($setting) {
                    $setting->value = '0';
                    $setting->save();
                    Cache::put("setting.{$key}", '0', 60 * 60 * 24);
                }
            }
        }

        return redirect()->route('admin.settings')->with('success', 'Cài đặt đã được cập nhật thành công!');
    }

    public function clearCache()
    {
        SettingsHelper::clearCache();

        return redirect()->route('admin.settings')->with('success', 'Cache đã được xóa thành công!');
    }

    /**
     * Reset all settings to default values
     */
    public function resetToDefaults()
    {
        // Run the settings seeder to restore defaults
        $seeder = new \Database\Seeders\SettingsSeeder();
        $seeder->run();

        // Clear cache
        Cache::flush();

        return redirect()->route('admin.settings')->with('success', 'Cài đặt đã được khôi phục về mặc định!');
    }
}
