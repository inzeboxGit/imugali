<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageHeaderSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class ContactPageController extends Controller
{
    public function index()
    {
        $contactPageSetting = $this->resolveSetting();
        if (method_exists($contactPageSetting, 'loadMissing')) {
            $contactPageSetting->loadMissing('translations');
        }
        $locales = config('content_translations.locales', ['fr' => 'Français']);

        // Load general site settings
        $siteSetting = null;
        $frontThemes = $this->availableFrontThemes();
        $supportsFooterBackgroundImage = false;

        if (Schema::hasTable('site_settings')) {
            $siteSetting = \App\Models\SiteSetting::firstOrCreate(
                ['setting_key' => 'general'],
                $this->siteSettingDefaults()
            );
            $supportsFooterBackgroundImage = Schema::hasColumn('site_settings', 'footer_background_image');
        }

        return view('admin.contact.index', compact(
            'contactPageSetting', 
            'locales', 
            'siteSetting', 
            'frontThemes', 
            'supportsFooterBackgroundImage'
        ));
    }

    public function update(Request $request)
    {
        if (! Schema::hasTable('page_header_settings')) {
            return redirect()->route('admin.contact.index')->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $setting = $this->resolveSetting();
        $data = $request->validate([
            'info_booking_label' => ['nullable', 'string', 'max:255'],
            'select_room_label' => ['nullable', 'string', 'max:255'],
            'adults_label' => ['nullable', 'string', 'max:255'],
            'children_label' => ['nullable', 'string', 'max:255'],
            'book_now_label' => ['nullable', 'string', 'max:255'],
            'map_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'map_longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        $setting->update([
            'info_booking_label' => array_key_exists('info_booking_label', $data) ? $data['info_booking_label'] : $setting->info_booking_label,
            'select_room_label' => array_key_exists('select_room_label', $data) ? $data['select_room_label'] : $setting->select_room_label,
            'adults_label' => array_key_exists('adults_label', $data) ? $data['adults_label'] : $setting->adults_label,
            'children_label' => array_key_exists('children_label', $data) ? $data['children_label'] : $setting->children_label,
            'book_now_label' => array_key_exists('book_now_label', $data) ? $data['book_now_label'] : $setting->book_now_label,
            'map_latitude' => array_key_exists('map_latitude', $data) ? $data['map_latitude'] : $setting->map_latitude,
            'map_longitude' => array_key_exists('map_longitude', $data) ? $data['map_longitude'] : $setting->map_longitude,
        ]);

        $translatedFields = [
            'info_booking_label',
            'select_room_label',
            'adults_label',
            'children_label',
            'book_now_label',
        ];
        $translationPayload = $request->input('translations', []);
        $locales = array_keys(config('content_translations.locales', ['fr' => 'Français']));

        foreach ($translationPayload as $locale => $fields) {
            if ($locale === 'fr' || ! in_array($locale, $locales, true) || ! is_array($fields)) {
                continue;
            }

            foreach ($translatedFields as $field) {
                $setting->setTranslation($field, $locale, $fields[$field] ?? null);
            }
        }

        return redirect()->route('admin.contact.index')->with('success', 'Paramètres de la page contact mis à jour.');
    }

    private function resolveSetting(): object
    {
        $defaults = [
            'page' => 'contact',
            'subtitle' => '',
            'title' => '',
            'info_booking_label' => 'Téléphone',
            'select_room_label' => 'Prénom',
            'adults_label' => 'Nom',
            'children_label' => 'Message',
            'book_now_label' => 'Envoyer',
            'map_latitude' => 42.6043096,
            'map_longitude' => 8.9295210,
            'header_image' => '',
        ];

        if (! Schema::hasTable('page_header_settings')) {
            return (object) $defaults;
        }

        return PageHeaderSetting::firstOrCreate(
            ['page' => 'contact'],
            $defaults
        );
    }

    private function siteSettingDefaults(): array
    {
        $defaults = [
            'site_name' => '',
            'address' => '',
            'email' => '',
            'use_site_email_for_contact' => true,
            'contact_recipient_email' => null,
            'phone_primary' => '',
            'phone_secondary' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'whatsapp_url' => '',
            'twitter_url' => '',
            'default_locale' => config('app.locale', 'fr'),
            'front_theme' => 'default',
            'maintenance_enabled' => false,
            'maintenance_message' => '',
            'custom_head_scripts' => '',
            'footer_background_image' => '',
        ];

        if (Schema::hasTable('site_settings')) {
            if (! Schema::hasColumn('site_settings', 'maintenance_message')) {
                unset($defaults['maintenance_message']);
            }
            if (! Schema::hasColumn('site_settings', 'use_site_email_for_contact')) {
                unset($defaults['use_site_email_for_contact']);
            }
            if (! Schema::hasColumn('site_settings', 'contact_recipient_email')) {
                unset($defaults['contact_recipient_email']);
            }
            if (! Schema::hasColumn('site_settings', 'default_locale')) {
                unset($defaults['default_locale']);
            }
            if (! Schema::hasColumn('site_settings', 'front_theme')) {
                unset($defaults['front_theme']);
            }
            if (! Schema::hasColumn('site_settings', 'custom_head_scripts')) {
                unset($defaults['custom_head_scripts']);
            }
            if (! Schema::hasColumn('site_settings', 'footer_background_image')) {
                unset($defaults['footer_background_image']);
            }
        }

        return $defaults;
    }

    private function availableFrontThemes(): array
    {
        $themes = ['default' => 'Thème actuel'];
        $themesPath = resource_path('views/themes');

        if (! is_dir($themesPath)) {
            return $themes;
        }

        $entries = scandir($themesPath) ?: [];

        foreach ($entries as $entry) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }

            if (! preg_match('/^[a-z0-9_-]+$/i', $entry)) {
                continue;
            }

            if (! is_dir($themesPath . DIRECTORY_SEPARATOR . $entry)) {
                continue;
            }

            $key = strtolower($entry);

            if ($key === 'default') {
                continue;
            }

            $label = ucwords(str_replace(['-', '_'], ' ', $key));
            $themes[$key] = $label;
        }

        ksort($themes);

        if (isset($themes['default'])) {
            $defaultLabel = $themes['default'];
            unset($themes['default']);
            $themes = ['default' => $defaultLabel] + $themes;
        }

        return $themes;
    }
}
