@extends('admin.layout')

@section('title', 'Contact & Paramètres')

@push('css')
    <style>
        /* Premium custom upload style */
        .custom-upload-zone {
            border: 2px dashed #BD945A !important;
            background-color: #fcfcf9;
            transition: all 0.2s ease;
            border-radius: 8px;
            position: relative;
            padding: 1.8rem 1rem;
            text-align: center;
            cursor: pointer;
        }

        .custom-upload-zone:hover {
            background-color: #f7f3eb;
            border-color: #a88048 !important;
        }

        .custom-upload-zone input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .custom-upload-zone .upload-icon {
            color: #BD945A;
            font-size: 2rem;
            margin-bottom: 0.4rem;
        }

        .custom-upload-zone .upload-text {
            font-weight: 600;
            color: #4a4a4a;
            font-size: 0.9rem;
        }

        .custom-upload-zone .upload-desc {
            color: #7a7a7a;
            font-size: 0.75rem;
        }

        /* Section Styling */
        .form-section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
            margin-bottom: 1.2rem;
        }
    </style>
@endpush

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">Contact & Paramètres</h1>
            <div class="text-muted">Gérer les coordonnées, réseaux sociaux et configuration de la page contact</div>
        </div>
        <a href="{{ url('/contacts') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">Voir la page
            contact</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Section 1: Contact Page Settings -->
    <div class="admin-card p-4 mb-4">
        <h2 class="h5 mb-3 fw-semibold text-dark">
            <i class="bi bi-envelope-paper text-primary me-1"></i> Paramètres de la page Contact
        </h2>
        <form action="{{ route('admin.contact.update') }}" method="post" enctype="multipart/form-data">
            @csrf


            <div class="form-section-title">Coordonnées de la Carte GPS</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Latitude GPS</label>
                    <input type="number" step="0.0000001" name="map_latitude" class="form-control"
                        value="{{ old('map_latitude', $contactPageSetting->map_latitude ?? '42.6043096') }}"
                        placeholder="42.6043096">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Longitude GPS</label>
                    <input type="number" step="0.0000001" name="map_longitude" class="form-control"
                        value="{{ old('map_longitude', $contactPageSetting->map_longitude ?? '8.9295210') }}"
                        placeholder="8.9295210">
                </div>
            </div>

            <div class="form-section-title">Libellés du Formulaire de Contact</div>
            <div class="mb-4">
                <ul class="nav nav-tabs" id="contact-booking-labels-tabs" role="tablist">
                    @foreach($locales as $localeKey => $localeLabel)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                id="contact-booking-labels-{{ $localeKey }}-tab" data-bs-toggle="tab"
                                data-bs-target="#contact-booking-labels-{{ $localeKey }}" type="button" role="tab"
                                aria-controls="contact-booking-labels-{{ $localeKey }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $localeLabel }}
                            </button>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content border border-top-0 rounded-bottom p-3 bg-white">
                    @foreach($locales as $localeKey => $localeLabel)
                        @php
                            $isFrench = $localeKey === 'fr';
                            $valueFor = function (string $field) use ($contactPageSetting, $localeKey, $isFrench) {
                                if ($isFrench) {
                                    return old($field, $contactPageSetting->{$field} ?? '');
                                }

                                $translatedValue = '';
                                if (method_exists($contactPageSetting, 'translations') && $contactPageSetting->relationLoaded('translations')) {
                                    $translatedValue = $contactPageSetting->translations
                                        ->first(fn($item) => $item->locale === $localeKey && $item->field === $field)?->value ?? '';
                                }

                                return old('translations.' . $localeKey . '.' . $field, $translatedValue);
                            };
                        @endphp
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                            id="contact-booking-labels-{{ $localeKey }}" role="tabpanel"
                            aria-labelledby="contact-booking-labels-{{ $localeKey }}-tab" tabindex="0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Prénom (Libellé / Placeholder)</label>
                                    <input type="text"
                                        name="{{ $isFrench ? 'select_room_label' : 'translations[' . $localeKey . '][select_room_label]' }}"
                                        class="form-control" value="{{ $valueFor('select_room_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Nom (Libellé / Placeholder)</label>
                                    <input type="text"
                                        name="{{ $isFrench ? 'adults_label' : 'translations[' . $localeKey . '][adults_label]' }}"
                                        class="form-control" value="{{ $valueFor('adults_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Téléphone (Libellé / Placeholder)</label>
                                    <input type="text"
                                        name="{{ $isFrench ? 'info_booking_label' : 'translations[' . $localeKey . '][info_booking_label]' }}"
                                        class="form-control" value="{{ $valueFor('info_booking_label') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Message (Libellé / Placeholder)</label>
                                    <input type="text"
                                        name="{{ $isFrench ? 'children_label' : 'translations[' . $localeKey . '][children_label]' }}"
                                        class="form-control" value="{{ $valueFor('children_label') }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-medium">Bouton Envoyer (Texte du bouton)</label>
                                    <input type="text"
                                        name="{{ $isFrench ? 'book_now_label' : 'translations[' . $localeKey . '][book_now_label]' }}"
                                        class="form-control" value="{{ $valueFor('book_now_label') }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-text mt-2 text-muted">
                    <i class="bi bi-info-circle me-1"></i> Ces libellés s'appliquent directement comme étiquettes (labels) et espaces réservés (placeholders) dans le formulaire de contact public.
                </div>
            </div>


            <div class="pt-2 border-top mt-4 text-end">
                <button class="btn btn-primary px-4 py-2 fw-semibold" type="submit">
                    <i class="bi bi-save me-1"></i> Enregistrer la page contact
                </button>
            </div>
        </form>
    </div>

    <!-- Section 2: General Site Settings -->
    @if($siteSetting)
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-gear text-primary me-1"></i> Paramètres Généraux du Site
            </h2>
            <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $footerBackgroundSrc = media_url($siteSetting->footer_background_image ?? null, 'img/rooms/3.jpg');
                @endphp

                <div class="form-section-title mt-2">Identité & Configuration</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nom du site</label>
                        <input type="text" name="site_name" class="form-control"
                            value="{{ old('site_name', $siteSetting->site_name ?? '') }}" placeholder="Ex: Résidence Mugali">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Email principal de contact</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $siteSetting->email ?? '') }}"
                            placeholder="Ex: contact@residence-mugali.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Langue par défaut du site</label>
                        <select name="default_locale" class="form-select">
                            @foreach(($locales ?? ['fr' => 'Français']) as $localeKey => $localeLabel)
                                <option value="{{ $localeKey }}" {{ old('default_locale', $siteSetting->default_locale ?? config('app.locale', 'fr')) === $localeKey ? 'selected' : '' }}>
                                    {{ $localeLabel }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Thème front</label>
                        <select name="front_theme" class="form-select">
                            @foreach(($frontThemes ?? ['default' => 'Thème actuel']) as $themeKey => $themeLabel)
                                <option value="{{ $themeKey }}" {{ old('front_theme', $siteSetting->front_theme ?? 'default') === $themeKey ? 'selected' : '' }}>
                                    {{ $themeLabel }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted">Applique le thème graphique sur la partie publique.</div>
                    </div>
                </div>

                <div class="form-section-title">Destinataires des Formulaires de Contact</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="use_site_email_for_contact"
                                name="use_site_email_for_contact" {{ old('use_site_email_for_contact', $siteSetting->use_site_email_for_contact ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="use_site_email_for_contact">
                                Utiliser l'email principal du site comme destinataire des messages
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12" id="contact_recipient_email_wrap">
                        <label class="form-label fw-medium">Autre email destinataire</label>
                        <input type="email" name="contact_recipient_email" class="form-control"
                            value="{{ old('contact_recipient_email', $siteSetting->contact_recipient_email ?? '') }}"
                            placeholder="Ex: reservations@residence-mugali.com">
                        <div class="form-text text-muted">Utilisé seulement si la case ci-dessus est décochée.</div>
                    </div>
                </div>

                <div class="form-section-title">Coordonnées téléphoniques & Adresse physique</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Téléphone principal</label>
                        <input type="text" name="phone_primary" class="form-control"
                            value="{{ old('phone_primary', $siteSetting->phone_primary ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Téléphone secondaire (Optionnel)</label>
                        <input type="text" name="phone_secondary" class="form-control"
                            value="{{ old('phone_secondary', $siteSetting->phone_secondary ?? '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Adresse postale</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $siteSetting->address ?? '') }}">
                    </div>
                </div>

                <div class="form-section-title">Réseaux Sociaux</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Facebook</label>
                        <input type="text" name="facebook_url" class="form-control"
                            value="{{ old('facebook_url', $siteSetting->facebook_url ?? '') }}"
                            placeholder="https://facebook.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Instagram</label>
                        <input type="text" name="instagram_url" class="form-control"
                            value="{{ old('instagram_url', $siteSetting->instagram_url ?? '') }}"
                            placeholder="https://instagram.com/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">WhatsApp</label>
                        <input type="text" name="whatsapp_url" class="form-control"
                            value="{{ old('whatsapp_url', $siteSetting->whatsapp_url ?? '') }}" placeholder="https://wa.me/...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Twitter / X</label>
                        <input type="text" name="twitter_url" class="form-control"
                            value="{{ old('twitter_url', $siteSetting->twitter_url ?? '') }}" placeholder="https://x.com/...">
                    </div>
                </div>

                <div class="form-section-title">Scripts Web personnalisés (Google Analytics, Pixel...)</div>
                <div class="row g-3 mb-4">
                    <div class="col-12">
                        <label class="form-label fw-medium">Scripts personnalisés (Head)</label>
                        <textarea name="custom_head_scripts" class="form-control" rows="5"
                            placeholder="&lt;script&gt;...&lt;/script&gt;">{{ old('custom_head_scripts', $siteSetting->custom_head_scripts ?? '') }}</textarea>
                        <div class="form-text text-muted">Ces scripts seront ajoutés dans la balise &lt;head&gt; de toutes les
                            pages.</div>
                    </div>
                </div>

                @if($supportsFooterBackgroundImage ?? false)
                    <div class="form-section-title">Image de fond du footer</div>
                    <div class="mb-4">
                        <div class="custom-upload-zone">
                            <input type="file" name="footer_background_image" id="footer_background_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image-fill"></i>
                            </div>
                            <span class="upload-text d-block" id="footer_background_image_label">Déposer ou cliquer pour
                                uploader</span>
                            <span class="upload-desc d-block mt-1">Image d'arrière-plan du pied de page</span>
                        </div>

                        <!-- Preview stacked below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 320px;">
                                <img id="footer_background_image_preview" src="{{ $footerBackgroundSrc }}" alt="Aperçu footer"
                                    style="max-height: 140px; max-width: 100%; object-fit: cover; border-radius: 4px; display: inline-block;">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="pt-2 border-top mt-4 text-end">
                    <button class="btn btn-primary px-4 py-2 fw-semibold" type="submit">
                        <i class="bi bi-save me-1"></i> Enregistrer les paramètres généraux
                    </button>
                </div>
            </form>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bindPreview = function (inputId, previewId, labelId) {
                const fileInput = document.getElementById(inputId);
                const filePreview = document.getElementById(previewId);

                if (!fileInput || !filePreview) return;

                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file) return;

                    if (labelId) {
                        const label = document.getElementById(labelId);
                        if (label) {
                            label.textContent = file.name;
                            label.classList.add('text-primary');
                        }
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        filePreview.src = e.target.result;
                        filePreview.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(file);
                });
            };

            bindPreview('footer_background_image', 'footer_background_image_preview', 'footer_background_image_label');

            const checkbox = document.getElementById('use_site_email_for_contact');
            const wrap = document.getElementById('contact_recipient_email_wrap');

            if (checkbox && wrap) {
                const syncVisibility = function () {
                    wrap.style.display = checkbox.checked ? 'none' : '';
                };

                checkbox.addEventListener('change', syncVisibility);
                syncVisibility();
            }
        });
    </script>
@endsection