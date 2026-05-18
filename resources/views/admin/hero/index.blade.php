@extends('admin.layout')

@section('title', 'Hero accueil')

@push('css')
    <style>
        /* Premium custom upload style */
        .custom-upload-zone {
            border: 2px dashed #BD945A !important;
            background-color: #fcfcf9;
            transition: all 0.2s ease;
            border-radius: 8px;
            position: relative;
            padding: 2.2rem 1.2rem;
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
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .custom-upload-zone .upload-text {
            font-weight: 600;
            color: #4a4a4a;
            font-size: 0.95rem;
        }

        .custom-upload-zone .upload-desc {
            color: #7a7a7a;
            font-size: 0.8rem;
        }

        /* Tabs Navigation styling */
        .hero-nav-tabs {
            border-bottom: none;
            gap: 8px;
        }

        .hero-nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border-radius: 6px !important;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            padding: 0.75rem 1.25rem;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .hero-nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            border-color: #ced4da;
        }

        .hero-nav-tabs .nav-link.active {
            background-color: #BD945A !important;
            color: #ffffff !important;
            border-color: #BD945A !important;
            box-shadow: 0 4px 10px rgba(189, 148, 90, 0.2);
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
            <h1 class="h3 mb-1">Hero accueil</h1>
            <div class="text-muted">Gérer les titres, les arrière-plans média (vidéo ou image) et les différentes sections
                de la page d'accueil</div>
        </div>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary" target="_blank" rel="noopener">
            <i class="bi bi-box-arrow-up-right me-1"></i> Voir le site
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Unified Section Tabs -->
    <ul class="nav nav-tabs hero-nav-tabs mb-4" id="hero-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-hero-tab" data-bs-toggle="tab" data-bs-target="#tab-hero" type="button"
                role="tab" aria-controls="tab-hero" aria-selected="true">
                <i class="bi bi-play-circle fs-5"></i> Hero Principal
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-ambiance-tab" data-bs-toggle="tab" data-bs-target="#tab-ambiance" type="button"
                role="tab" aria-controls="tab-ambiance" aria-selected="false">
                <i class="bi bi-camera-video fs-5"></i> Section Ambiance
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-footer-tab" data-bs-toggle="tab" data-bs-target="#tab-footer" type="button"
                role="tab" aria-controls="tab-footer" aria-selected="false">
                <i class="bi bi-window-dock fs-5"></i> Section Pré-footer
            </button>
        </li>
    </ul>

    <div class="tab-content" id="hero-tabs-content">

        <!-- ==================== TAB 1: HERO PRINCIPAL ==================== -->
        <div class="tab-pane fade show active" id="tab-hero" role="tabpanel" aria-labelledby="tab-hero-tab">
            <form action="{{ route('admin.hero.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $backgroundSrc = null;
                    $backgroundType = old('background_type', $heroSetting->background_type ?? 'video');
                    $backgroundVideo = old('background_video', $heroSetting->background_video ?? 'video/sunset.mp4');
                    $backgroundVideoSrc = str_starts_with($backgroundVideo, 'video/')
                        ? asset($backgroundVideo)
                        : asset('storage/' . $backgroundVideo);
                    $youtubeVideoUrl = old('youtube_video_url', $heroSetting->youtube_video_url ?? '');
                    if (!empty($heroSetting->background_image ?? null)) {
                        $backgroundSrc = str_starts_with($heroSetting->background_image, 'img/')
                            ? asset($heroSetting->background_image)
                            : asset('storage/' . $heroSetting->background_image);
                    }
                @endphp

                <div class="card border-0 shadow-sm p-4">
                    <h2 class="h5 mb-4 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-sliders text-primary"></i> Configuration de la section principale
                    </h2>

                    <!-- Section: Textes -->
                    <div class="form-section-title">Contenu Textuel</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Petit titre</label>
                            <input type="text" name="small_title" class="form-control"
                                value="{{ old('small_title', $heroSetting->small_title ?? '') }}"
                                placeholder="Ex: Bienvenue">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Titre Principal</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $heroSetting->title ?? '') }}"
                                placeholder="Ex: Résidence de prestige">
                        </div>
                    </div>

                    <!-- Section: Boutons -->
                    <div class="form-section-title">Bouton d'Action</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Texte du bouton</label>
                            <input type="text" name="button_text" class="form-control"
                                value="{{ old('button_text', $heroSetting->button_text ?? '') }}"
                                placeholder="Ex: Découvrir Le Domaine">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-medium">Lien du bouton Header</label>
                            <input type="text" name="button_link" class="form-control"
                                value="{{ old('button_link', $heroSetting->button_link ?? '') }}"
                                placeholder="Ex: /appartements ou https://...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-medium">Cible du lien</label>
                            <select name="button_target" class="form-select">
                                <option value="_self" {{ old('button_target', $heroSetting->button_target ?? '_self') === '_self' ? 'selected' : '' }}>Même onglet</option>
                                <option value="_blank" {{ old('button_target', $heroSetting->button_target ?? '_self') === '_blank' ? 'selected' : '' }}>Nouvel onglet</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section: Arrière-plan -->
                    <div class="form-section-title">Gestion de l'Arrière-plan</div>
                    <div class="mb-4">
                        <label class="form-label fw-medium d-block mb-3">Type de média de fond</label>
                        <div class="btn-group w-100" role="group" aria-label="Type de fond">
                            <input type="radio" class="btn-check" name="background_type"
                                id="hero_background_type_video" value="video" {{ $backgroundType === 'video' ? 'checked' : '' }} autocomplete="off">
                            <label class="btn btn-outline-secondary py-2" for="hero_background_type_video">
                                <i class="bi bi-film me-2"></i> Vidéo d'ambiance
                            </label>

                            <input type="radio" class="btn-check" name="background_type"
                                id="hero_background_type_image" value="image" {{ $backgroundType === 'image' ? 'checked' : '' }} autocomplete="off">
                            <label class="btn btn-outline-secondary py-2" for="hero_background_type_image">
                                <i class="bi bi-image me-2"></i> Image d'arrière-plan
                            </label>
                        </div>
                    </div>

                    <!-- Sub-fields for Video -->
                    <div class="mb-4" id="hero_background_video_fields">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Fichier vidéo local</label>
                                <div class="custom-upload-zone">
                                    <input type="file" name="background_video" id="hero_background_video"
                                        accept="video/mp4,video/webm,video/ogg,video/quicktime">
                                    <div class="upload-icon">
                                        <i class="bi bi-cloud-upload"></i>
                                    </div>
                                    <span class="upload-text d-block" id="hero_background_video_label">Déposer ou
                                        cliquer pour uploader</span>
                                    <span class="upload-desc d-block mt-1">MP4, WebM, OGG (Taille max: 50 Mo)</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Lien vidéo YouTube</label>
                                <input type="url" name="youtube_video_url" class="form-control mb-2"
                                    value="{{ $youtubeVideoUrl }}"
                                    placeholder="https://www.youtube.com/watch?v=...">
                                <div class="form-text mt-1 text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Si renseigné, le lien YouTube est
                                    prioritaire sur le fichier local uploader.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-fields for Image -->
                    <div class="mb-4" id="hero_background_image_field">
                        <label class="form-label fw-medium">Fichier image</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="background_image" id="hero_background_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <span class="upload-text d-block" id="hero_background_image_label">Déposer ou cliquer
                                pour uploader</span>
                            <span class="upload-desc d-block mt-1">JPG, PNG, WEBP, SVG</span>
                        </div>
                    </div>

                    <!-- Live Media Preview (Stacked Below) -->
                    <div class="mt-4 pt-3 border-top">
                        <div class="text-muted small mb-2 fw-semibold text-start">
                            <i class="bi bi-eye text-primary me-1"></i> Aperçu du média actif (Fond actuel : <span id="hero_current_type_label" class="badge bg-secondary">{{ $backgroundType === 'video' ? 'Vidéo' : 'Image' }}</span>) :
                        </div>
                        <div class="border rounded bg-light p-3 text-center" style="max-width: 480px; margin: 0 auto;">
                            <video id="hero_background_video_preview" src="{{ $backgroundVideoSrc }}"
                                style="max-height: 230px; max-width: 100%; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); {{ $backgroundType === 'video' ? 'display: inline-block;' : 'display: none;' }}"
                                controls muted playsinline></video>
                            <img id="hero_background_preview" src="{{ $backgroundSrc }}" alt="Image"
                                style="max-height: 230px; max-width: 100%; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); {{ $backgroundType === 'image' && !empty($backgroundSrc) ? 'display: inline-block;' : 'display: none;' }}">
                        </div>
                    </div>

                    <div class="pt-2 border-top mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ==================== TAB 2: IMAGE D'AMBIANCE ==================== -->
        <div class="tab-pane fade" id="tab-ambiance" role="tabpanel" aria-labelledby="tab-ambiance-tab">
            <form action="{{ route('admin.hero.video-section.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $videoSectionImageSrc = media_url($homeVideoSetting->header_image ?? null, 'img/video-background.png');
                @endphp

                <div class="card border-0 shadow-sm p-4">
                    <h2 class="h5 mb-4 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-camera-video text-primary"></i> Section image d'ambiance après about
                    </h2>

                    <div class="form-section-title">Contenu Textuel</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Sous-titre</label>
                            <input type="text" name="subtitle" class="form-control"
                                value="{{ old('subtitle', $homeVideoSetting->subtitle ?? '') }}"
                                placeholder="Ex: Notre univers">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Titre</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $homeVideoSetting->title ?? '') }}"
                                placeholder="Ex: Une ambiance relaxante">
                        </div>
                    </div>

                    <div class="form-section-title">Fichier Image d'Arrière-plan</div>
                    <div class="mb-4">
                        <div class="custom-upload-zone">
                            <input type="file" name="header_image" id="home_video_header_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <span class="upload-text d-block" id="home_video_header_image_label">Déposer ou cliquer
                                pour uploader</span>
                            <span class="upload-desc d-block mt-1">JPG, PNG, WEBP (Taille recommandée: 1920x1080)</span>
                        </div>
                    </div>

                    <!-- Live Image Preview (Stacked Below) -->
                    <div class="mt-4 pt-3 border-top text-center">
                        <div class="text-muted small mb-2 fw-semibold text-start">
                            <i class="bi bi-eye text-primary me-1"></i> Aperçu de l'image d'ambiance :
                        </div>
                        <div class="border rounded bg-light p-3 d-inline-block" style="max-width: 480px;">
                            <img id="home_video_header_preview" src="{{ $videoSectionImageSrc }}" alt="Aperçu ambiance"
                                style="max-height: 230px; max-width: 100%; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); {{ !empty($videoSectionImageSrc) ? 'display: inline-block;' : 'display: none;' }}">
                        </div>
                    </div>

                    <div class="pt-2 border-top mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Mettre à jour la section
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- ==================== TAB 3: SECTION PRE-FOOTER ==================== -->
        <div class="tab-pane fade" id="tab-footer" role="tabpanel" aria-labelledby="tab-footer-tab">
            <form action="{{ route('admin.hero.before-footer.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $beforeFooterImageSrc = media_url($beforeFooterSetting->header_image ?? null, null);
                @endphp

                <div class="card border-0 shadow-sm p-4">
                    <h2 class="h5 mb-4 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-window-dock text-primary"></i> Section avant le pied de page
                    </h2>

                    <div class="form-section-title">Contenu Textuel</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Sous-titre</label>
                            <input type="text" name="subtitle" class="form-control"
                                value="{{ old('subtitle', $beforeFooterSetting->subtitle ?? '') }}"
                                placeholder="Ex: Rejoignez-nous">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Titre</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $beforeFooterSetting->title ?? '') }}"
                                placeholder="Ex: Réservez votre séjour de rêve">
                        </div>
                    </div>

                    <div class="form-section-title">Fichier Image</div>
                    <div class="mb-4">
                        <div class="custom-upload-zone">
                            <input type="file" name="header_image" id="before_footer_header_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <span class="upload-text d-block" id="before_footer_header_image_label">Déposer ou
                                cliquer pour uploader</span>
                            <span class="upload-desc d-block mt-1">JPG, PNG, WEBP (Image grand format)</span>
                        </div>
                    </div>

                    <!-- Live Image Preview (Stacked Below) -->
                    <div class="mt-4 pt-3 border-top text-center">
                        <div class="text-muted small mb-2 fw-semibold text-start">
                            <i class="bi bi-eye text-primary me-1"></i> Aperçu de l'image pré-footer :
                        </div>
                        <div class="border rounded bg-light p-3 d-inline-block" style="max-width: 480px;">
                            <img id="before_footer_header_preview" src="{{ $beforeFooterImageSrc }}"
                                alt="Aperçu avant-footer"
                                style="max-height: 230px; max-width: 100%; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); {{ !empty($beforeFooterImageSrc) ? 'display: inline-block;' : 'display: none;' }}">
                        </div>
                    </div>

                    <div class="pt-2 border-top mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold">
                            <i class="bi bi-save me-1"></i> Mettre à jour la section
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ----------------------------------------------------
            // Tab Persistence Logic
            // ----------------------------------------------------
            const activeTabId = localStorage.getItem('hero_active_tab') || 'tab-hero-tab';
            const activeTabEl = document.getElementById(activeTabId);
            if (activeTabEl) {
                const tabInstance = new bootstrap.Tab(activeTabEl);
                tabInstance.show();
            }

            const tabButtons = document.querySelectorAll('#hero-tabs button');
            tabButtons.forEach(btn => {
                btn.addEventListener('shown.bs.tab', function (e) {
                    localStorage.setItem('hero_active_tab', e.target.id);
                });
            });

            // ----------------------------------------------------
            // Background Toggle Logic (Video vs Image)
            // ----------------------------------------------------
            const typeInputs = document.querySelectorAll('input[name="background_type"]');
            const videoFields = document.getElementById('hero_background_video_fields');
            const imageField = document.getElementById('hero_background_image_field');
            const typeLabel = document.getElementById('hero_current_type_label');
            const heroVideoPreview = document.getElementById('hero_background_video_preview');
            const heroImagePreview = document.getElementById('hero_background_preview');

            function toggleBackgroundFields() {
                const selectedInput = document.querySelector('input[name="background_type"]:checked');
                const selectedType = selectedInput ? selectedInput.value : 'video';

                if (videoFields) {
                    videoFields.style.display = selectedType === 'video' ? 'block' : 'none';
                }
                if (imageField) {
                    imageField.style.display = selectedType === 'image' ? 'block' : 'none';
                }
                if (typeLabel) {
                    typeLabel.textContent = selectedType === 'video' ? 'Vidéo' : 'Image';
                }
                if (heroVideoPreview) {
                    heroVideoPreview.style.display = selectedType === 'video' ? 'block' : 'none';
                }
                if (heroImagePreview) {
                    heroImagePreview.style.display = selectedType === 'image' && heroImagePreview.src ? 'block' : 'none';
                }
            }

            typeInputs.forEach(input => {
                input.addEventListener('change', toggleBackgroundFields);
            });

            // Initial trigger
            toggleBackgroundFields();

            // ----------------------------------------------------
            // Generic Live Preview & Custom Input Label Helpers
            // ----------------------------------------------------
            function initImagePreview(inputId, previewId, labelId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const label = document.getElementById(labelId);
                if (!input || !preview) return;

                input.addEventListener('change', function (e) {
                    const file = e.target.files && e.target.files[0];
                    if (!file) return;

                    // Update custom zone label
                    if (label) {
                        label.textContent = file.name;
                        label.classList.add('text-primary');
                    }

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        preview.src = event.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                });
            }

            function initVideoPreview(inputId, previewId, labelId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const label = document.getElementById(labelId);
                if (!input || !preview) return;

                input.addEventListener('change', function (e) {
                    const file = e.target.files && e.target.files[0];
                    if (!file) return;

                    // Update custom zone label
                    if (label) {
                        label.textContent = file.name;
                        label.classList.add('text-primary');
                    }

                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                });
            }

            // Initialize all fields
            initVideoPreview('hero_background_video', 'hero_background_video_preview', 'hero_background_video_label');
            initImagePreview('hero_background_image', 'hero_background_preview', 'hero_background_image_label');
            initImagePreview('home_video_header_image', 'home_video_header_preview', 'home_video_header_image_label');
            initImagePreview('before_footer_header_image', 'before_footer_header_preview', 'before_footer_header_image_label');
        });
    </script>
@endsection