@extends('admin.layout')

@section('title', $pageMeta['title'])

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
            font-size: 0.95rem;
            font-weight: 600;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.4rem;
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
    @php
        $crudLabels = $pageMeta['crud_labels'] ?? [];
    @endphp
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $pageMeta['title'] }}</h1>
            <div class="text-muted">{{ $pageMeta['description'] }} 
                <a href="#table" class="text-decoration-underline">Menu restaurant</a>
                 | | 
                <a href="#table" class="text-decoration-underline">Gallerie restaurant</a>
            </div>
        </div>
        <a href="{{ route($pageMeta['routes']['create']) }}" class="btn btn-primary">Ajouter</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($pageMeta['section_settings']['enabled'])
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-sliders text-primary me-1"></i> {{ $pageMeta['section_settings']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['routes']['section_settings']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $headerSrc = media_url($sectionSetting->header_image ?? null);
                @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Sous-titre</label>
                        <input type="text" name="subtitle" class="form-control"
                            value="{{ old('subtitle', $sectionSetting->subtitle ?? '') }}"
                            placeholder="Ex: iMugali">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $sectionSetting->title ?? '') }}"
                            placeholder="Ex: Le Domaine">
                    </div>
                    @if($pageMeta['section_settings']['show_hero_text'])
                        <div class="col-12">
                            <label class="form-label fw-medium">Texte hero</label>
                            <textarea name="hero_text" class="form-control"
                                rows="3" placeholder="Saisir la description principale...">{{ old('hero_text', $sectionSetting->hero_text ?? '') }}</textarea>
                        </div>
                    @endif
                    
                    <!-- Header Image Custom Zone -->
                    <div class="col-12 mt-3">
                        <label class="form-label fw-medium">Image header</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="header_image" id="restaurant_header_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image"></i>
                            </div>
                            <span class="upload-text d-block" id="restaurant_header_image_label">Déposer ou cliquer pour uploader</span>
                            <span class="upload-desc d-block mt-1">Image grand format (Recommandé: 1920x1080)</span>
                        </div>
                        
                        <!-- Preview Stacked Below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 320px;">
                                <img id="restaurant_header_preview" src="{{ $headerSrc ?? '' }}" alt="Aperçu header"
                                    style="max-height: 140px; max-width: 100%; object-fit: cover; border-radius: 4px; {{ empty($headerSrc) ? 'display:none;' : 'display: inline-block;' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($pageMeta['about_section']['enabled'])
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-file-earmark-richtext text-primary me-1"></i> {{ $pageMeta['about_section']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['about_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $aboutMainSrc = media_url($aboutSectionSetting->main_image ?? null, 'img/home_2.jpg');
                    $aboutOverlaySrc = media_url($aboutSectionSetting->overlay_image ?? null, 'img/home_1.jpg');
                @endphp
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Petit titre</label>
                        <input type="text" name="small_title" class="form-control"
                            value="{{ old('small_title', $aboutSectionSetting->small_title ?? '') }}"
                            placeholder="Ex: À PROPOS DE LA PISCINE">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $aboutSectionSetting->title ?? '') }}"
                            placeholder="Ex: La Piscine Bella Vista">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Signature</label>
                        <input type="text" name="signature" class="form-control"
                            value="{{ old('signature', $aboutSectionSetting->signature ?? '') }}"
                            placeholder="Ex: L'équipe de la Piscine">
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label fw-medium">Lead (Introduction)</label>
                        <input type="text" name="lead" class="form-control"
                            value="{{ old('lead', $aboutSectionSetting->lead ?? '') }}"
                            placeholder="Ex: Un espace de détente ouvert sur la résidence...">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control"
                            rows="5" placeholder="Saisir la description complète...">{{ old('description', $aboutSectionSetting->description ?? '') }}</textarea>
                    </div>
                    
                    <!-- Images Columns -->
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-medium">Image principale</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="main_image" id="about_main_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-image-fill"></i>
                            </div>
                            <span class="upload-text d-block" id="about_main_image_label">Déposer ou cliquer pour uploader</span>
                            @if(($pageMeta['title'] ?? '') === 'Piscine')
                                <span class="upload-desc d-block mt-1">Format requis: 1920 x 1080 px</span>
                            @else
                                <span class="upload-desc d-block mt-1">Format recommandé: 800 x 600 px</span>
                            @endif
                        </div>
                        
                        <!-- Preview Stacked Below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 280px;">
                                <img id="about_main_preview" src="{{ $aboutMainSrc }}" alt="Aperçu principal"
                                    style="max-height: 120px; max-width: 100%; object-fit: cover; border-radius: 4px; display: inline-block;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-4">
                        <label class="form-label fw-medium">Image superposée</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="overlay_image" id="about_overlay_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-images"></i>
                            </div>
                            <span class="upload-text d-block" id="about_overlay_image_label">Déposer ou cliquer pour uploader</span>
                            <span class="upload-desc d-block mt-1">Image superposée décorative</span>
                        </div>
                        
                        <!-- Preview Stacked Below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 280px;">
                                <img id="about_overlay_preview" src="{{ $aboutOverlaySrc }}" alt="Aperçu superposé"
                                    style="max-height: 120px; max-width: 100%; object-fit: cover; border-radius: 4px; display: inline-block;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($pageMeta['extra_text_section']['enabled'])
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-file-earmark-text text-primary me-1"></i> {{ $pageMeta['extra_text_section']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['extra_text_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $extraImageOneSrc = media_url($extraTextSectionSetting->main_image ?? null);
                    $extraImageTwoSrc = media_url($extraTextSectionSetting->overlay_image ?? null);
                    $extraImageThreeSrc = media_url($extraTextSectionSetting->third_image ?? null);
                    $reqDim = $pageMeta['extra_text_section']['image_dimensions'] ?? ['width' => 800, 'height' => 1200];
                @endphp
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Sous-titre</label>
                        <input type="text" name="subtitle" class="form-control"
                            value="{{ old('subtitle', $extraTextSectionSetting->small_title ?? '') }}"
                            placeholder="Ex: Section après À propos">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $extraTextSectionSetting->title ?? '') }}"
                            placeholder="Ex: Informations complémentaires">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control"
                            rows="4" placeholder="Saisir la description...">{{ old('description', $extraTextSectionSetting->description ?? '') }}</textarea>
                    </div>
                    
                    @if($pageMeta['extra_text_section']['show_images'])
                        <!-- Three Images Row -->
                        <div class="col-md-4 mt-3">
                            <label class="form-label fw-medium">Photo 1</label>
                            <div class="custom-upload-zone">
                                <input type="file" name="image_one" id="extra_image_one" accept="image/*">
                                <div class="upload-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <span class="upload-text d-block" id="extra_image_one_label">Déposer ou cliquer</span>
                                <span class="upload-desc d-block mt-1">Format requis: {{ $reqDim['width'] }} x {{ $reqDim['height'] }} px</span>
                            </div>
                            <!-- Preview stacked below -->
                            <div class="mt-3 text-center">
                                <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 100%;">
                                    <img id="extra_image_one_preview" src="{{ $extraImageOneSrc ?? '' }}" alt="Aperçu photo 1"
                                        style="max-height: 130px; border-radius: 4px; {{ empty($extraImageOneSrc) ? 'display:none;' : 'display: inline-block;' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mt-3">
                            <label class="form-label fw-medium">Photo 2</label>
                            <div class="custom-upload-zone">
                                <input type="file" name="image_two" id="extra_image_two" accept="image/*">
                                <div class="upload-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <span class="upload-text d-block" id="extra_image_two_label">Déposer ou cliquer</span>
                                <span class="upload-desc d-block mt-1">Format requis: {{ $reqDim['width'] }} x {{ $reqDim['height'] }} px</span>
                            </div>
                            <!-- Preview stacked below -->
                            <div class="mt-3 text-center">
                                <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 100%;">
                                    <img id="extra_image_two_preview" src="{{ $extraImageTwoSrc ?? '' }}" alt="Aperçu photo 2"
                                        style="max-height: 130px; border-radius: 4px; {{ empty($extraImageTwoSrc) ? 'display:none;' : 'display: inline-block;' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mt-3">
                            <label class="form-label fw-medium">Photo 3</label>
                            <div class="custom-upload-zone">
                                <input type="file" name="image_three" id="extra_image_three" accept="image/*">
                                <div class="upload-icon">
                                    <i class="bi bi-camera"></i>
                                </div>
                                <span class="upload-text d-block" id="extra_image_three_label">Déposer ou cliquer</span>
                                <span class="upload-desc d-block mt-1">Format requis: {{ $reqDim['width'] }} x {{ $reqDim['height'] }} px</span>
                            </div>
                            <!-- Preview stacked below -->
                            <div class="mt-3 text-center">
                                <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 100%;">
                                    <img id="extra_image_three_preview" src="{{ $extraImageThreeSrc ?? '' }}" alt="Aperçu photo 3"
                                        style="max-height: 130px; border-radius: 4px; {{ empty($extraImageThreeSrc) ? 'display:none;' : 'display: inline-block;' }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if($pageMeta['secondary_extra_section']['enabled'])
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-file-earmark-medical text-primary me-1"></i> {{ $pageMeta['secondary_extra_section']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['secondary_extra_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $secondaryExtraMainSrc = media_url($secondaryExtraSectionSetting->main_image ?? null);
                    $secondaryExtraOverlaySrc = media_url($secondaryExtraSectionSetting->overlay_image ?? null);
                    $mainDims = $pageMeta['secondary_extra_section']['main_image_dimensions'] ?? ['width' => 1920, 'height' => 1080];
                    $overlayDims = $pageMeta['secondary_extra_section']['overlay_image_dimensions'] ?? ['width' => 1920, 'height' => 1080];
                @endphp
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-medium">Titre</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $secondaryExtraSectionSetting->title ?? '') }}"
                            placeholder="Ex: Section complémentaire">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control"
                            rows="4" placeholder="Saisir la description...">{{ old('description', $secondaryExtraSectionSetting->description ?? '') }}</textarea>
                    </div>
                    
                    <!-- Two Images Columns -->
                    <div class="col-md-6 mt-3">
                        <label class="form-label fw-medium">Photo 1</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="main_image" id="secondary_extra_main_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                            <span class="upload-text d-block" id="secondary_extra_main_image_label">Déposer ou cliquer</span>
                            <span class="upload-desc d-block mt-1">Format requis: {{ $mainDims['width'] }} x {{ $mainDims['height'] }} px</span>
                        </div>
                        <!-- Preview stacked below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 100%;">
                                <img id="secondary_extra_main_preview" src="{{ $secondaryExtraMainSrc ?? '' }}" alt="Aperçu photo 1"
                                    style="max-height: 130px; border-radius: 4px; {{ empty($secondaryExtraMainSrc) ? 'display:none;' : 'display: inline-block;' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mt-3">
                        <label class="form-label fw-medium">Photo 2</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="overlay_image" id="secondary_extra_overlay_image" accept="image/*">
                            <div class="upload-icon">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                            <span class="upload-text d-block" id="secondary_extra_overlay_image_label">Déposer ou cliquer</span>
                            <span class="upload-desc d-block mt-1">Format requis: {{ $overlayDims['width'] }} x {{ $overlayDims['height'] }} px</span>
                        </div>
                        <!-- Preview stacked below -->
                        <div class="mt-3 text-center">
                            <div class="border rounded bg-light p-2 d-inline-block" style="max-width: 100%;">
                                <img id="secondary_extra_overlay_preview" src="{{ $secondaryExtraOverlaySrc ?? '' }}" alt="Aperçu photo 2"
                                    style="max-height: 130px; border-radius: 4px; {{ empty($secondaryExtraOverlaySrc) ? 'display:none;' : 'display: inline-block;' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if(($pageMeta['restaurant_info_section']['enabled'] ?? false))
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-clock-history text-primary me-1"></i> {{ $pageMeta['restaurant_info_section']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['restaurant_info_section']['route']) }}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Titre heures</label>
                        <input type="text" name="small_title" class="form-control"
                            value="{{ old('small_title', $restaurantInfoSectionSetting->small_title ?? '') }}"
                            placeholder="Ex: Hours">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-medium">Horaires</label>
                        <textarea name="lead" class="form-control" rows="5" placeholder="Ex: Breakfast: 7.00 am - 11.00 am...">{{ old('lead', $restaurantInfoSectionSetting->lead ?? '') }}</textarea>
                        <small class="text-muted d-block mt-1">Une ligne par horaire.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Titre dress code</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $restaurantInfoSectionSetting->title ?? '') }}"
                            placeholder="Ex: Dress Code">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-medium">Texte dress code</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Ex: Smart casual...">{{ old('description', $restaurantInfoSectionSetting->description ?? '') }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Titre terrasse</label>
                        <input type="text" name="signature" class="form-control"
                            value="{{ old('signature', $restaurantInfoSectionSetting->signature ?? '') }}"
                            placeholder="Ex: Terrace">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-medium">Texte terrasse</label>
                        <textarea name="main_image" class="form-control" rows="3" placeholder="Ex: Open for drinks only...">{{ old('main_image', $restaurantInfoSectionSetting->main_image ?? '') }}</textarea>
                    </div>
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if(($pageMeta['gallery_section']['enabled'] ?? false))
        <div class="admin-card p-4 mb-4">
            <h2 class="h5 mb-3 fw-semibold text-dark">
                <i class="bi bi-images text-primary me-1"></i> {{ $pageMeta['gallery_section']['title'] }}
            </h2>
            <form action="{{ route($pageMeta['gallery_section']['route']) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Sous-titre</label>
                        <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $restaurantGallerySetting->small_title ?? 'Image Gallery') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Titre</label>
                        <input type="text" name="gallery_title" class="form-control" value="{{ old('gallery_title', $restaurantGallerySetting->title ?? 'Restaurant Gallery') }}">
                    </div>
                    {{-- Existing images --}}
                    @php $galleryImages = $restaurantGallerySetting->gallery ?? []; @endphp
                    @if(!empty($galleryImages))
                        <div class="col-12">
                            <label class="form-label fw-medium">Images actuelles</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($galleryImages as $imgPath)
                                    @php $imgSrc = media_url($imgPath); @endphp
                                    <div class="position-relative" style="width:120px;">
                                        <img src="{{ $imgSrc }}" alt="" class="rounded" style="width:120px;height:90px;object-fit:cover;">
                                        <label class="position-absolute top-0 end-0 m-1 d-flex align-items-center justify-content-center bg-danger rounded-circle" style="width:22px;height:22px;cursor:pointer;" title="Supprimer">
                                            <input type="checkbox" name="remove[]" value="{{ $imgPath }}" class="d-none gallery-remove-cb">
                                            <span class="text-white" style="font-size:13px;line-height:1;">&times;</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-1">Cochez la croix rouge pour supprimer une image.</small>
                        </div>
                    @endif
                    
                    <div class="col-12 mt-3">
                        <label class="form-label fw-medium">Ajouter des images</label>
                        <div class="custom-upload-zone">
                            <input type="file" name="images[]" id="gallery_images" accept="image/*" multiple>
                            <div class="upload-icon">
                                <i class="bi bi-cloud-arrow-up-fill"></i>
                            </div>
                            <span class="upload-text d-block" id="gallery_images_label">Déposer ou cliquer pour ajouter des photos</span>
                            <span class="upload-desc d-block mt-1">Format requis : 1080 × 900 px. Plusieurs fichiers acceptés.</span>
                        </div>
                    </div>
                    
                    <div class="col-12 text-end pt-2 border-top mt-4">
                        <button class="btn btn-primary px-4 fw-semibold" type="submit">
                            <i class="bi bi-save me-1"></i> Mettre à jour la galerie
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    <div class="admin-card p-3" id="table">
        <form method="get" action="{{ route($pageMeta['routes']['index']) }}" class="row g-3 align-items-end mb-3">
            <div class="col-md-4 col-lg-3">
                <label for="category" class="form-label mb-1">Filtrer par {{ $crudLabels['table_title'] ?? 'Titre' }}</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Tous</option>
                    @foreach(($categoryOptions ?? collect()) as $categoryOption)
                        <option value="{{ $categoryOption }}" {{ ($activeCategoryFilter ?? '') === $categoryOption ? 'selected' : '' }}>
                            {{ $categoryOption }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Filtrer</button>
            </div>
            @if(!empty($activeCategoryFilter))
                <div class="col-auto">
                    <a href="{{ route($pageMeta['routes']['index']) }}" class="btn btn-outline-secondary">Réinitialiser</a>
                </div>
            @endif
        </form>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>{{ $crudLabels['table_small_title'] ?? 'Petit titre' }}</th>
                        <th>{{ $crudLabels['table_title'] ?? 'Titre' }}</th>
                        <th>{{ $crudLabels['table_sort_order'] ?? 'Ordre' }}</th>
                        <th>Publiée</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comodites as $comodite)
                        <tr>
                            <td>
                                @php
                                    $src = media_url($comodite->image_path);
                                @endphp
                                @if($src)
                                    <img src="{{ $src }}" alt="{{ $comodite->title }}"
                                        style="width:56px;height:56px;object-fit:cover;border-radius:8px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $comodite->small_title ?: '-' }}</td>
                            <td>{{ $comodite->title }}</td>
                            <td>{{ $comodite->sort_order }}</td>
                            <td>{{ $comodite->is_published ? 'Oui' : 'Non' }}</td>
                            <td class="text-end">
                                <a href="{{ route($pageMeta['routes']['edit'], $comodite) }}"
                                    class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route($pageMeta['routes']['destroy'], $comodite) }}" method="post"
                                    class="d-inline" onsubmit="return confirm('Supprimer cet élément ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ $pageMeta['empty_label'] }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $comodites->links('pagination::bootstrap-5') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bindPreview = function (inputId, previewId, labelId) {
                const fileInput = document.getElementById(inputId);
                const filePreview = document.getElementById(previewId);

                if (!fileInput || !filePreview) {
                    return;
                }

                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files && event.target.files[0];
                    if (!file) {
                        return;
                    }

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

            bindPreview('restaurant_header_image', 'restaurant_header_preview', 'restaurant_header_image_label');
            bindPreview('about_main_image', 'about_main_preview', 'about_main_image_label');
            bindPreview('about_overlay_image', 'about_overlay_preview', 'about_overlay_image_label');
            bindPreview('extra_image_one', 'extra_image_one_preview', 'extra_image_one_label');
            bindPreview('extra_image_two', 'extra_image_two_preview', 'extra_image_two_label');
            bindPreview('extra_image_three', 'extra_image_three_preview', 'extra_image_three_label');
            bindPreview('secondary_extra_main_image', 'secondary_extra_main_preview', 'secondary_extra_main_image_label');
            bindPreview('secondary_extra_overlay_image', 'secondary_extra_overlay_preview', 'secondary_extra_overlay_image_label');
            
            // Multiple gallery images label handler
            const galleryInput = document.getElementById('gallery_images');
            const galleryLabel = document.getElementById('gallery_images_label');
            if (galleryInput && galleryLabel) {
                galleryInput.addEventListener('change', function() {
                    const filesCount = this.files.length;
                    if (filesCount > 0) {
                        galleryLabel.textContent = filesCount + " fichier(s) sélectionné(s)";
                        galleryLabel.classList.add('text-primary');
                    }
                });
            }
        });
    </script>
@endsection