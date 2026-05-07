<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutSectionSetting;
use App\Models\LocalAmenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class RestaurantAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_RESTAURANT;
    protected string $routePrefix = 'admin.restaurant';
    protected string $pageTitle = 'Restaurant';
    protected string $pageDescription = 'Gerer la page Restaurant et ses elements affiches sur le front';
    protected string $itemLabelSingular = 'item menu restaurant';
    protected string $itemLabelPlural = 'items menu restaurant';
    protected ?string $emptyStateLabel = 'Aucun item menu restaurant';
    protected ?string $sectionSettingsSuccessMessage = 'Paramètres Restaurant mis à jour.';
    protected ?array $sectionSettingConfig = [
        'section' => 'about_local_amenities',
        'panel_title' => 'Paramètres de la page Restaurant',
        'header_image' => 'img/home_2.jpg',
        'subtitle' => '',
        'title' => '',
        'hero_text' => '',
        'supports_hero_text' => true,
    ];
    protected ?array $aboutSectionConfig = [
        'section' => 'restaurant_about',
        'panel_title' => 'Section À propos Restaurant',
        'small_title' => '',
        'title' => '',
        'lead' => '',
        'description' => '',
        'signature' => '',
        'main_image' => 'img/home_2.jpg',
        'overlay_image' => 'img/home_1.jpg',
        'image_directory' => 'restaurant-about',
        'success_message' => 'Section À propos Restaurant mise à jour.',
    ];
    protected ?array $extraTextSectionConfig = [
        'section' => 'restaurant_after_about',
        'panel_title' => 'Section après À propos Restaurant',
        'subtitle' => '',
        'title' => '',
        'description' => '',
        'success_message' => 'Section après À propos Restaurant mise à jour.',
    ];

    public function updateRestaurantInfoSectionSettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $data = $request->validate([
            'small_title' => ['nullable', 'string', 'max:255'],
            'lead' => ['nullable', 'string'],
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'signature' => ['nullable', 'string', 'max:255'],
            'main_image' => ['nullable', 'string'],
        ]);

        $this->resolveRestaurantInfoSectionSetting()->update($data);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Informations pratiques Restaurant mises à jour.');
    }

    protected function viewData(array $extra = []): array
    {
        $data = parent::viewData(array_merge([
            'restaurantInfoSectionSetting' => $this->resolveRestaurantInfoSectionSetting(),
            'restaurantGallerySetting'     => $this->resolveRestaurantGallerySetting(),
        ], $extra));

        $data['pageMeta']['restaurant_info_section'] = [
            'enabled' => true,
            'title' => 'Informations pratiques Restaurant',
            'route' => 'admin.restaurant.info-section.update',
        ];

        $data['pageMeta']['gallery_section'] = [
            'enabled' => true,
            'title'   => 'Galerie Restaurant',
            'route'   => 'admin.restaurant.gallery-settings.update',
        ];

        $data['pageMeta']['crud_labels'] = [
            'small_title' => 'Nom du plat',
            'title' => 'Titre de l’onglet',
            'sort_order' => 'Prix',
            'description' => 'Description du plat',
            'link_url' => 'Lien (optionnel laisse vide)',
            'image' => 'Image (optionnelle optionnel laisse vide)',
            'table_small_title' => 'Plat',
            'table_title' => 'Onglet',
            'table_sort_order' => 'Prix',
        ];

        return $data;
    }

    protected function resolveRestaurantInfoSectionSetting(): object
    {
        $defaults = [
            'small_title' => 'Hours',
            'title' => 'Dress Code',
            'lead' => "Breakfast: 7.00 am - 11.00 am (daily)\nLunch: 12.00 noon - 2.00 pm (daily)\nDinner: open from 6.30 pm, last order at 10.00 pm (daily)",
            'description' => 'Smart casual (no shorts, hats, or sandals permitted).',
            'signature' => 'Terrace',
            'main_image' => 'Open for drinks only.',
            'overlay_image' => '',
            'third_image' => '',
        ];

        if (! Schema::hasTable('about_section_settings')) {
            return (object) $defaults;
        }

        return AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_info_block'],
            $defaults
        );
    }

    public function updateGallerySettings(Request $request)
    {
        if (! Schema::hasTable('about_section_settings')) {
            return redirect()->route($this->indexRouteName())
                ->with('success', 'Table des paramètres indisponible sur cet environnement.');
        }

        $request->validate([
            'images.*'    => ['nullable', 'image', 'max:10240', 'dimensions:width=1080,height=900'],
            'remove'      => ['nullable', 'array'],
            'remove.*'    => ['string'],
            'small_title' => ['nullable', 'string', 'max:255'],
            'gallery_title' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = $this->resolveRestaurantGallerySetting();
        $gallery = $setting->gallery ?? [];

        // Remove deleted images
        foreach (($request->input('remove', [])) as $path) {
            if (! str_starts_with($path, 'img/')) {
                Storage::disk('public')->delete($path);
            }
            $gallery = array_values(array_filter($gallery, fn ($p) => $p !== $path));
        }

        // Add new uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $this->storeResizedImage($file, 'restaurant-gallery', 1080, 900);
                $gallery[] = $path;
            }
        }

        $setting->update([
            'gallery'     => $gallery,
            'small_title' => $request->input('small_title', $setting->small_title),
            'title'       => $request->input('gallery_title', $setting->title),
        ]);

        return redirect()->route($this->indexRouteName())
            ->with('success', 'Galerie Restaurant mise à jour.');
    }

    protected function resolveRestaurantGallerySetting(): AboutSectionSetting
    {
        return AboutSectionSetting::firstOrCreate(
            ['section' => 'restaurant_gallery'],
            [
                'small_title' => 'Image Gallery',
                'title'       => 'Restaurant Gallery',
                'gallery'     => [],
            ]
        );
    }
}
