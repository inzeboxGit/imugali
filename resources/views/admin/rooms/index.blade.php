@extends('admin.layout')

@section('title', 'Chambres')

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
            <h1 class="h3 mb-1">Chambres</h1>
            <div class="text-muted">Gérer les chambres</div>
        </div>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Ajouter une chambre</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="admin-card p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="h5 mb-0 fw-semibold text-dark">
                <i class="bi bi-sliders text-primary me-1"></i> Paramètres page Appartements
            </h2>
            <a href="{{ route('appartements.index') }}" class="btn btn-sm btn-outline-secondary" target="_blank"
                rel="noopener">
                <i class="bi bi-box-arrow-up-right me-1"></i> Voir la page
            </a>
        </div>
        <form action="{{ route('admin.rooms.page-settings.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @php
                $headerSrc = null;
                if (!empty($appartmentPageSetting->header_image ?? null)) {
                    $headerSrc = str_starts_with($appartmentPageSetting->header_image, 'img/')
                        ? asset($appartmentPageSetting->header_image)
                        : asset('storage/' . $appartmentPageSetting->header_image);
                }
            @endphp
            
            <!-- Section 1: Page Header -->
            <div class="form-section-title mt-2">En-tête de la Page (Bandeau principal)</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Petit titre</label>
                    <input type="text" name="subtitle" class="form-control"
                        value="{{ old('subtitle', $appartmentPageSetting->subtitle ?? '') }}"
                        placeholder="Ex: Luxury Hotel Experience">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Titre Principal</label>
                    <input type="text" name="title" class="form-control"
                        value="{{ old('title', $appartmentPageSetting->title ?? '') }}"
                        placeholder="Ex: Our Rooms & Suites">
                </div>
            </div>

            <!-- Section 2: Home Section -->
            <div class="form-section-title">Section sur la Page d'Accueil</div>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-medium">Petit titre de la section accueil</label>
                    <input type="text" name="home_subtitle" class="form-control"
                        value="{{ old('home_subtitle', $appartmentPageSetting->home_subtitle ?? '') }}"
                        placeholder="Ex: Expérience hôtelière">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-medium">Titre de la section accueil</label>
                    <input type="text" name="home_title" class="form-control"
                        value="{{ old('home_title', $appartmentPageSetting->home_title ?? '') }}"
                        placeholder="Ex: Nos appartements">
                </div>
            </div>

            <!-- Section 3: Header Image -->
            <div class="form-section-title">Image d'Arrière-plan de l'En-tête</div>
            <div class="mb-4">
                <div class="custom-upload-zone">
                    <input type="file" name="header_image" id="appartement_header_image" accept="image/*">
                    <div class="upload-icon">
                        <i class="bi bi-image"></i>
                    </div>
                    <span class="upload-text d-block" id="appartement_header_image_label">Déposer ou cliquer pour uploader</span>
                    <span class="upload-desc d-block mt-1">Image grand format (Recommandé: 1920x1080)</span>
                </div>
            </div>

            <!-- Preview Stacked Below -->
            <div class="mt-4 pt-3 border-top text-center">
                <div class="text-muted small mb-2 fw-semibold text-start">
                    <i class="bi bi-eye text-primary me-1"></i> Image d'en-tête actuelle / nouvelle :
                </div>
                <div class="border rounded bg-light p-3 d-inline-block" style="max-width: 480px;">
                    <img id="appartement_header_preview" src="{{ $headerSrc ?? '' }}" alt="Aperçu en-tête"
                        style="max-height: 230px; max-width: 100%; object-fit: cover; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); {{ empty($headerSrc) ? 'display:none;' : 'display: inline-block;' }}">
                </div>
            </div>

            <div class="pt-2 border-top mt-4 text-end">
                <button class="btn btn-primary px-4 py-2 fw-semibold" type="submit">
                    <i class="bi bi-save me-1"></i> Mettre à jour les paramètres
                </button>
            </div>
        </form>
    </div>

    <div class="admin-card p-3">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>ID associé</th>
                        <th>Prix / nuit</th>
                        <th>Statut</th>
                        <th>Créée</th>
                        <th>Dernière mise à jour</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $room->title }}</div>
                                <div class="text-muted small">{{ $room->slug }}</div>
                            </td>
                            <td>{{ $room->external_id ?: '-' }}</td>
                            <td>{{ $room->price_per_night ? number_format($room->price_per_night, 2) . ' €' : '-' }}</td>
                            <td>
                                <span class="badge {{ $room->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $room->status === 'published' ? 'Publié' : 'Brouillon' }}
                                </span>
                            </td>
                            <td>{{ $room->created_at->format('d/m/Y') }}</td>
                            <td>{{ $room->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('appartements.index') }}" class="btn btn-sm btn-outline-secondary"
                                    target="_blank" rel="noopener">Aperçu</a>
                                <a href="{{ route('admin.rooms.edit', $room) }}"
                                    class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="post" class="d-inline"
                                    onsubmit="return confirm('Supprimer cette chambre ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucune chambre</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $rooms->links('pagination::bootstrap-5') }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('appartement_header_image');
            const preview = document.getElementById('appartement_header_preview');

            if (!input || !preview) return;

            input.addEventListener('change', function (event) {
                const file = event.target.files && event.target.files[0];
                if (!file) return;

                // Update custom zone label
                const label = document.getElementById('appartement_header_image_label');
                if (label) {
                    label.textContent = file.name;
                    label.classList.add('text-primary');
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection