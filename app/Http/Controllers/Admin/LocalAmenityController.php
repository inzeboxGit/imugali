<?php

namespace App\Http\Controllers\Admin;

use App\Models\LocalAmenity;

class LocalAmenityController extends AbstractLocalAmenityController
{
    protected string $displayContext = LocalAmenity::CONTEXT_HOME;
    protected string $routePrefix = 'admin.comodites';
    protected string $pageTitle = 'Commodités accueil';
    protected string $pageDescription = "Gerer les commodites locales affichees sur la page d'accueil";
    protected string $itemLabelSingular = 'commodité';
    protected string $itemLabelPlural = 'commodités';
    protected ?string $emptyStateLabel = "Aucune commodité d'accueil";
    protected ?array $sectionSettingConfig = [
        'section' => 'home_local_amenities',
        'panel_title' => 'Titre & sous-titre de la section Activités',
        'header_image' => '',
        'subtitle' => 'Nos Activités',
        'title' => 'Activités & Excursions',
        'hero_text' => '',
        'supports_hero_text' => false,
    ];
}
