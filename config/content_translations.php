<?php

return [
    'locales' => [
        'fr' => 'Français',
        'en' => 'English',
        'de' => 'Deutsch',
        'it' => 'Italiano',
    ],

    'types' => [
        'about_section' => [
            'label' => 'Section À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
        ],
        'home_hero' => [
            'label' => 'Hero accueil',
            'class' => \App\Models\HomeHeroSetting::class,
            'fields' => ['small_title', 'title', 'dates_label', 'adults_label', 'children_label', 'search_label'],
            'display_field' => 'section',
        ],
        'promo_section' => [
            'label' => 'Section Promo',
            'class' => \App\Models\PromoSectionSetting::class,
            'fields' => ['subtitle', 'title', 'text', 'button_text'],
            'wysiwyg_fields' => ['text'],
            'display_field' => 'title',
        ],
        'installation_section' => [
            'label' => 'Service accueil - Section',
            'class' => \App\Models\InstallationSectionSetting::class,
            'fields' => ['subtitle', 'title'],
            'display_field' => 'section',
        ],
        'local_amenity_section' => [
            'label' => 'Section Commodités',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
        ],
        'restaurant_page' => [
            'label' => 'Auberge - Header',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
            'where' => [
                'section' => 'about_local_amenities',
            ],
        ],
        'restaurant_about' => [
            'label' => 'Auberge - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'restaurant_about',
            ],
        ],
        'restaurant_extra_text' => [
            'label' => 'Auberge - Après À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'restaurant_after_about',
            ],
        ],
        'restaurant_items' => [
            'label' => 'Auberge - Contenu',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
            'where' => [
                'display_context' => \App\Models\LocalAmenity::CONTEXT_RESTAURANT,
            ],
        ],
        'pool_page' => [
            'label' => 'Le Domaine - Header',
            'class' => \App\Models\LocalAmenitySectionSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text'],
            'display_field' => 'section',
            'where' => [
                'section' => 'about_pool_amenities',
            ],
        ],
        'pool_about' => [
            'label' => 'Le Domaine - À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'lead', 'description', 'signature'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'pool_about',
            ],
        ],
        'pool_extra_text' => [
            'label' => 'Le Domaine - Après À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'pool_after_about',
            ],
        ],
        'pool_items' => [
            'label' => 'Le Domaine - Contenu',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
            'where' => [
                'display_context' => \App\Models\LocalAmenity::CONTEXT_POOL,
            ],
        ],
        'pool_bottom_section' => [
            'label' => 'Le Domaine - Section complémentaire',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'pool_bottom_section',
            ],
        ],
        'activites_about' => [
            'label' => 'Activités - Section À propos',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'section',
            'where' => [
                'section' => 'activites_about',
            ],
        ],
        'activites_gallery' => [
            'label' => 'Activités - Section Galerie',
            'class' => \App\Models\AboutSectionSetting::class,
            'fields' => ['small_title', 'title'],
            'display_field' => 'section',
            'where' => [
                'section' => 'activites_gallery',
            ],
        ],
        'page_headers' => [
            'label' => 'En-têtes de page',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'hero_text', 'availability_small', 'availability_title', 'availability_text'],
            'display_field' => 'page',
        ],
        'contact_page' => [
            'label' => 'Page Contact',
            'class' => \App\Models\PageHeaderSetting::class,
            'fields' => ['subtitle', 'title', 'availability_small', 'availability_title', 'availability_text', 'info_booking_label', 'select_room_label', 'adults_label', 'children_label', 'book_now_label'],
            'display_field' => 'page',
            'where' => [
                'page' => 'contact',
            ],
        ],
        'appartment_page' => [
            'label' => 'Page Appartements',
            'class' => \App\Models\AppartmentPageSetting::class,
            'fields' => ['subtitle', 'title', 'home_subtitle', 'home_title'],
            'display_field' => 'page',
        ],
        'legal_pages' => [
            'label' => 'Conditions & Confidentialité',
            'class' => \App\Models\LegalPage::class,
            'fields' => ['header_subtitle', 'header_title', 'body'],
            'wysiwyg_fields' => ['body'],
            'display_field' => 'page',
        ],
        'site_settings' => [
            'label' => 'Paramètres site',
            'class' => \App\Models\SiteSetting::class,
            'fields' => ['site_name', 'address', 'maintenance_message'],
            'display_field' => 'setting_key',
        ],
        'amenities' => [
            'label' => 'Installations / Équipements',
            'class' => \App\Models\Amenity::class,
            'fields' => ['title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'local_amenities' => [
            'label' => 'Commodités locales',
            'class' => \App\Models\LocalAmenity::class,
            'fields' => ['small_title', 'title', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'rooms' => [
            'label' => 'Chambres',
            'class' => \App\Models\Room::class,
            'fields' => ['title', 'subtitle', 'description'],
            'wysiwyg_fields' => ['description'],
            'display_field' => 'title',
        ],
        'news' => [
            'label' => 'Actualités',
            'class' => \App\Models\News::class,
            'fields' => ['title', 'excerpt', 'body', 'category'],
            'wysiwyg_fields' => ['excerpt', 'body'],
            'display_field' => 'title',
        ],
        'testimonials' => [
            'label' => 'Témoignages',
            'class' => \App\Models\Testimonial::class,
            'fields' => ['name', 'content'],
            'wysiwyg_fields' => ['content'],
            'display_field' => 'name',
        ],
    ],
];
