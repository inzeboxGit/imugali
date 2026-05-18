@extends('admin.layout')

@section('title', 'À propos')

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
            font-size: 1.8rem;
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

        /* Image Preview Box Below Input */
        .preview-image-block {
            text-align: center;
            background: #fff;
            border: 1px solid #e9ecef;
            padding: 0.75rem;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: inline-block;
        }

        .preview-image-block img {
            border-radius: 4px;
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
        }

        /* Tabs Navigation styling */
        .about-nav-tabs {
            border-bottom: none;
            gap: 8px;
        }

        .about-nav-tabs .nav-link {
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

        .about-nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            border-color: #ced4da;
        }

        .about-nav-tabs .nav-link.active {
            background-color: #BD945A !important;
            color: #ffffff !important;
            border-color: #BD945A !important;
            box-shadow: 0 4px 10px rgba(189, 148, 90, 0.2);
        }

        /* Rich Editor Premium Styles */
        .rich-editor {
            border: 1px solid #ced4da;
            border-radius: 8px;
            background: #fff;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .rich-editor__toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 0.4rem;
            padding: 0.6rem;
            border-bottom: 1px solid #e9ecef;
            background: #f8f9fa;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .rich-editor__toolbar button {
            border: 1px solid #dee2e6;
            background: #fff;
            color: #495057;
            border-radius: 6px;
            padding: 0.35rem 0.65rem;
            font-size: 0.85rem;
            transition: all 0.15s ease;
            font-weight: 500;
        }

        .rich-editor__toolbar button:hover {
            background-color: #f1f3f5;
            border-color: #ced4da;
            color: #1a1a1a;
        }

        .rich-editor__content {
            min-height: 200px;
            padding: 1rem;
            outline: none;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .rich-editor__content:empty:before {
            content: attr(data-placeholder);
            color: #6c757d;
        }

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
            <h1 class="h3 mb-1">Section À propos</h1>
            <div class="text-muted">Gérer les contenus de présentation affichés sur la page d'accueil</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/') }}#first_section" class="btn btn-outline-secondary" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right me-1"></i> Section À propos 1
            </a>
            <a href="{{ url('/') }}#second_section" class="btn btn-outline-secondary" target="_blank" rel="noopener">
                <i class="bi bi-box-arrow-up-right me-1"></i> Section À propos 2
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Unified Section Tabs -->
    <ul class="nav nav-tabs about-nav-tabs mb-4" id="about-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-about1-tab" data-bs-toggle="tab" data-bs-target="#tab-about1"
                type="button" role="tab" aria-controls="tab-about1" aria-selected="true">
                <i class="bi bi-info-circle fs-5"></i> À propos 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-about2-tab" data-bs-toggle="tab" data-bs-target="#tab-about2" type="button"
                role="tab" aria-controls="tab-about2" aria-selected="false">
                <i class="bi bi-info-circle-fill fs-5"></i> À propos 2
            </button>
        </li>
    </ul>

    <div class="tab-content" id="about-tabs-content">

        <!-- ==================== TAB 1: À PROPOS 1 ==================== -->
        <div class="tab-pane fade show active" id="tab-about1" role="tabpanel" aria-labelledby="tab-about1-tab">
            <form action="{{ route('admin.about.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $mainSrc = null;
                    if (!empty($aboutSetting->main_image ?? null)) {
                        $mainSrc = str_starts_with($aboutSetting->main_image, 'img/')
                            ? asset($aboutSetting->main_image)
                            : asset('storage/' . $aboutSetting->main_image);
                    }
                    $aboutDescription = old('description', $aboutSetting->description ?? '');
                @endphp

                <div class="card border-0 shadow-sm p-4">
                    <h2 class="h5 mb-4 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-sliders text-primary"></i> Configuration de la section À propos 1
                    </h2>

                    <!-- Section: Textes -->
                    <div class="form-section-title">Contenu Textuel</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Petit titre</label>
                            <input type="text" name="small_title" class="form-control"
                                value="{{ old('small_title', $aboutSetting->small_title ?? '') }}"
                                placeholder="Ex: Notre histoire">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Titre principal</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $aboutSetting->title ?? '') }}" placeholder="Ex: Résidence Mugali">
                        </div>
                    </div>

                    <!-- Section: Boutons -->
                    <div class="form-section-title">Bouton d'Action</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Texte du bouton</label>
                            <input type="text" name="signature" class="form-control"
                                value="{{ old('signature', $aboutSetting->signature ?? '') }}"
                                placeholder="Ex: En savoir plus">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Lien du bouton</label>
                            <input type="text" name="button_link" class="form-control"
                                value="{{ old('button_link', $aboutSetting->button_link ?? '') }}"
                                placeholder="Ex: /restaurant ou https://...">
                        </div>
                    </div>

                    <!-- Section: Description (Rich Editor) -->
                    <div class="form-section-title">Description Détaillée</div>
                    <div class="mb-4">
                        <div class="rich-editor">
                            <div class="rich-editor__toolbar">
                                <button type="button" data-editor-command="bold"><strong>G</strong></button>
                                <button type="button" data-editor-command="italic"><em>I</em></button>
                                <button type="button" data-editor-command="underline"><u>S</u></button>
                                <button type="button" data-editor-command="insertUnorderedList">Liste</button>
                                <button type="button" data-editor-command="formatBlock"
                                    data-editor-value="p">Paragraphe</button>
                                <button type="button" data-editor-command="formatBlock"
                                    data-editor-value="h3">Titre</button>
                                <button type="button" data-editor-command="justifyLeft">Gauche</button>
                                <button type="button" data-editor-command="justifyCenter">Centre</button>
                                <button type="button" data-editor-command="justifyRight">Droite</button>
                                <button type="button" data-editor-command="justifyFull">Justifier</button>
                                <button type="button" data-editor-link="true">Lien</button>
                            </div>
                            <div class="rich-editor__content" id="about_description_editor" contenteditable="true"
                                data-placeholder="Saisissez la description...">{!! $aboutDescription !!}</div>
                        </div>
                        <textarea name="description" id="about_description" class="form-control d-none"
                            rows="5">{{ $aboutDescription }}</textarea>
                    </div>

                    <!-- Section: Images Upload -->
                    <div class="form-section-title">Médias de Présentation</div>
                    <div class="row g-4 align-items-start">
                        <div class="col-md-7">
                            <label class="form-label fw-medium">Image Principale</label>
                            <div class="custom-upload-zone">
                                <input type="file" name="main_image" id="about_main_image" accept="image/*">
                                <div class="upload-icon">
                                    <i class="bi bi-image"></i>
                                </div>
                                <span class="upload-text d-block" id="about_main_image_label">Déposer ou cliquer pour
                                    uploader</span>
                                <span class="upload-desc d-block mt-1">Image principale (Recadrée en 600x750)</span>
                            </div>
                        </div>
                        <div class="col-md-5 text-center mt-md-4 pt-md-2">
                            <div class="text-muted small mb-2 fw-semibold text-start">Image actuelle / nouvelle :</div>
                            <div class="preview-image-block">
                                <img id="about_main_preview" src="{{ $mainSrc ?? '' }}" alt="Aperçu principal"
                                    style="{{ empty($mainSrc) ? 'display:none;' : '' }}">
                            </div>
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

        <!-- ==================== TAB 2: À PROPOS 2 ==================== -->
        <div class="tab-pane fade" id="tab-about2" role="tabpanel" aria-labelledby="tab-about2-tab">
            <form action="{{ route('admin.about2.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                @php
                    $main2Src = null;
                    if (!empty($about2Setting->main_image ?? null)) {
                        $main2Src = str_starts_with($about2Setting->main_image, 'img/')
                            ? asset($about2Setting->main_image)
                            : asset('storage/' . $about2Setting->main_image);
                    }
                    $about2Description = old('description', $about2Setting->description ?? '');
                @endphp

                <div class="card border-0 shadow-sm p-4">
                    <h2 class="h5 mb-4 fw-semibold d-flex align-items-center gap-2">
                        <i class="bi bi-sliders text-primary"></i> Configuration de la section À propos 2
                    </h2>

                    <!-- Section: Textes -->
                    <div class="form-section-title">Contenu Textuel</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Petit titre</label>
                            <input type="text" name="small_title" class="form-control"
                                value="{{ old('small_title', $about2Setting->small_title ?? '') }}"
                                placeholder="Ex: Nos atouts">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Titre principal</label>
                            <input type="text" name="title" class="form-control"
                                value="{{ old('title', $about2Setting->title ?? '') }}"
                                placeholder="Ex: Qualité et confort">
                        </div>
                    </div>

                    <!-- Section: Boutons -->
                    <div class="form-section-title">Bouton d'Action</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Texte du bouton</label>
                            <input type="text" name="signature" class="form-control"
                                value="{{ old('signature', $about2Setting->signature ?? '') }}" placeholder="Ex: Découvrir">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Lien du bouton</label>
                            <input type="text" name="button_link" class="form-control"
                                value="{{ old('button_link', $about2Setting->button_link ?? '') }}"
                                placeholder="Ex: /appartements ou https://...">
                        </div>
                    </div>

                    <!-- Section: Description (Rich Editor) -->
                    <div class="form-section-title">Description Détaillée</div>
                    <div class="mb-4">
                        <div class="rich-editor">
                            <div class="rich-editor__toolbar">
                                <button type="button" data-editor-command="bold"><strong>G</strong></button>
                                <button type="button" data-editor-command="italic"><em>I</em></button>
                                <button type="button" data-editor-command="underline"><u>S</u></button>
                                <button type="button" data-editor-command="insertUnorderedList">Liste</button>
                                <button type="button" data-editor-command="formatBlock"
                                    data-editor-value="p">Paragraphe</button>
                                <button type="button" data-editor-command="formatBlock"
                                    data-editor-value="h3">Titre</button>
                                <button type="button" data-editor-command="justifyLeft">Gauche</button>
                                <button type="button" data-editor-command="justifyCenter">Centre</button>
                                <button type="button" data-editor-command="justifyRight">Droite</button>
                                <button type="button" data-editor-command="justifyFull">Justifier</button>
                                <button type="button" data-editor-link="true">Lien</button>
                            </div>
                            <div class="rich-editor__content" id="about2_description_editor" contenteditable="true"
                                data-placeholder="Saisissez la description...">{!! $about2Description !!}</div>
                        </div>
                        <textarea name="description" id="about2_description" class="form-control d-none"
                            rows="5">{{ $about2Description }}</textarea>
                    </div>

                    <!-- Section: Images Upload -->
                    <div class="form-section-title">Médias de Présentation</div>
                    <div class="row g-4 align-items-start">
                        <div class="col-md-7">
                            <label class="form-label fw-medium">Image Principale</label>
                            <div class="custom-upload-zone">
                                <input type="file" name="main_image" id="about2_main_image" accept="image/*">
                                <div class="upload-icon">
                                    <i class="bi bi-image"></i>
                                </div>
                                <span class="upload-text d-block" id="about2_main_image_label">Déposer ou cliquer pour
                                    uploader</span>
                                <span class="upload-desc d-block mt-1">Image principale (Recadrée en 600x750)</span>
                            </div>
                        </div>
                        <div class="col-md-5 text-center mt-md-4 pt-md-2">
                            <div class="text-muted small mb-2 fw-semibold text-start">Image actuelle / nouvelle :</div>
                            <div class="preview-image-block">
                                <img id="about2_main_preview" src="{{ $main2Src ?? '' }}" alt="Aperçu principal"
                                    style="{{ empty($main2Src) ? 'display:none;' : '' }}">
                            </div>
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ----------------------------------------------------
            // Tab Persistence Logic
            // ----------------------------------------------------
            const activeTabId = localStorage.getItem('about_active_tab') || 'tab-about1-tab';
            const activeTabEl = document.getElementById(activeTabId);
            if (activeTabEl) {
                const tabInstance = new bootstrap.Tab(activeTabEl);
                tabInstance.show();
            }

            const tabButtons = document.querySelectorAll('#about-tabs button');
            tabButtons.forEach(btn => {
                btn.addEventListener('shown.bs.tab', function (e) {
                    localStorage.setItem('about_active_tab', e.target.id);
                });
            });

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

            // Initialize file upload inputs with live previews
            initImagePreview('about_main_image', 'about_main_preview', 'about_main_image_label');
            initImagePreview('about2_main_image', 'about2_main_preview', 'about2_main_image_label');

            // ----------------------------------------------------
            // Rich Text Editor Setup
            // ----------------------------------------------------
            const setupEditor = (editorId, textareaId) => {
                const editor = document.getElementById(editorId);
                const textarea = document.getElementById(textareaId);
                if (!editor || !textarea) return;

                const syncEditor = () => { textarea.value = editor.innerHTML.trim(); };

                editor.closest('form')?.querySelectorAll('[data-editor-command], [data-editor-link]').forEach((button) => {
                    button.addEventListener('click', function () {
                        const command = this.dataset.editorCommand;
                        const value = this.dataset.editorValue;
                        editor.focus();
                        if (this.dataset.editorLink) {
                            const url = window.prompt('URL du lien');
                            if (!url) return;
                            document.execCommand('createLink', false, url);
                            syncEditor();
                            return;
                        }
                        document.execCommand(command, false, value || null);
                        syncEditor();
                    });
                });

                editor.addEventListener('input', syncEditor);
                editor.closest('form')?.addEventListener('submit', syncEditor);
            };

            setupEditor('about_description_editor', 'about_description');
            setupEditor('about2_description_editor', 'about2_description');
        });
    </script>
@endsection