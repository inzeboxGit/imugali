<?php

namespace App\Http\Controllers\Admin;

use App\Models\LocalAmenity;

class PoolAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_POOL;
    protected string $routePrefix = 'admin.pool';
    protected string $pageTitle = 'Le Domaine';
    protected string $pageDescription = 'Gerer la page Le Domaine et ses elements affiches sur le front';
    protected string $itemLabelSingular = 'élément domaine';
    protected string $itemLabelPlural = 'éléments domaine';
    protected string $linkPlaceholder = '/domaine';
    protected string $sectionImageDirectory = 'pool';
    protected ?string $emptyStateLabel = 'Aucun élément domaine';
    protected ?string $sectionSettingsSuccessMessage = 'Paramètres Le Domaine mis à jour.';
    protected ?array $sectionSettingConfig = [
        'section' => 'about_pool_amenities',
        'panel_title' => 'Paramètres de la page Piscine',
        'header_image' => 'img/home_2.jpg',
        'subtitle' => 'RÉsidence Bella vista',
        'title' => 'Piscine',
        'hero_text' => 'Une parenthèse de détente à la Résidence Bella Vista.',
        'supports_hero_text' => true,
    ];
    //upload piscine about section config
    protected ?array $aboutSectionConfig = [
        'section' => 'pool_about',
        'panel_title' => 'Section À propos Piscine',
        'small_title' => 'À PROPOS DE LA PISCINE',
        'title' => 'La Piscine Bella Vista',
        'lead' => 'Un espace de détente ouvert sur la résidence.',
        'description' => "Personnalisez ici le texte de présentation de la piscine, son ambiance et ses avantages pour les visiteurs.",
        'signature' => 'L’équipe de la Piscine',
        'main_image' => 'img/home_2.jpg',
        'main_image_dimensions' => ['width' => 1920, 'height' => 1080],
        'overlay_image' => 'img/home_1.jpg',
        'image_directory' => 'pool-about',
        'success_message' => 'Section À propos Piscine mise à jour.',
    ];

    protected ?array $extraTextSectionConfig = [
        'section' => 'pool_after_about',
        'panel_title' => 'Section après À propos 3',
        'subtitle' => '',
        'title' => '',
        'description' => '',
        'supports_images' => true,
        'image_directory' => 'pool-after-about',
        'image_dimensions' => ['width' => 800, 'height' => 1200],
        'success_message' => 'Section après À propos 3 mise à jour.',
    ];

    protected ?array $secondaryExtraSectionConfig = [
        'section' => 'pool_bottom_section',
        'panel_title' => 'Section complémentaire Le Domaine',
        'title' => '',
        'description' => '',
        'image_directory' => 'pool-bottom-section',
        'main_image_dimensions' => ['width' => 1920, 'height' => 1080],
        'overlay_image_dimensions' => ['width' => 1920, 'height' => 1080],
        'success_message' => 'Section complémentaire Piscine mise à jour.',
    ];
}
