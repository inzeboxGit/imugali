@php
    $crudLabels = $pageMeta['crud_labels'] ?? [];
@endphp

<div class="admin-card p-4">
    <div class="row g-3">
        
        <div class="col-md-6">
            <label class="form-label">{{ $crudLabels['title'] ?? 'Titre' }}</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $comodite->title ?? '') }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $crudLabels['small_title'] ?? 'Petit titre' }}</label>
            <input type="text" name="small_title" class="form-control" value="{{ old('small_title', $comodite->small_title ?? '') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">{{ $crudLabels['sort_order'] ?? 'Ordre' }}</label>
            <input type="number" min="0" name="sort_order" class="form-control" value="{{ old('sort_order', $comodite->sort_order ?? 0) }}">
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" id="is_published" name="is_published" {{ old('is_published', $comodite->is_published ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publiée</label>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">{{ $crudLabels['description'] ?? 'Description' }}</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $comodite->description ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $crudLabels['link_url'] ?? 'Lien (optionnel laisse vide)' }}</label>
            <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $comodite->link_url ?? $pageMeta['link_placeholder']) }}" placeholder="{{ $pageMeta['link_placeholder'] }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Prix</label>
            <input type="text" name="price" class="form-control" value="{{ old('price', $comodite->price ?? '') }}" placeholder="ex: 25€ / pers.">
        </div>
        <div class="col-md-6">
            <label class="form-label">{{ $crudLabels['image'] ?? 'Image' }}</label>
            <input type="file" name="image" id="comodite_image" class="form-control" accept="image/*">
            <input type="hidden" name="remove_image" id="comodite_remove_image" value="0">
            @php
                $existingSrc = media_url($comodite->image_path ?? null);
            @endphp
            <div class="mt-2 position-relative d-inline-block" id="comodite_image_wrapper" style="{{ empty($existingSrc) ? 'display:none;' : '' }}">
                <img id="comodite_image_preview" src="{{ $existingSrc ?? '' }}" alt="" class="rounded" style="max-height:120px;">
                <button type="button" id="comodite_image_remove_btn"
                    class="btn btn-danger btn-sm position-absolute top-0 end-0"
                    style="padding: 2px 6px; line-height:1;"
                    title="Supprimer l'image">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('comodite_image');
    const preview = document.getElementById('comodite_image_preview');
    const wrapper = document.getElementById('comodite_image_wrapper');
    const removeInput = document.getElementById('comodite_remove_image');
    const removeBtn = document.getElementById('comodite_image_remove_btn');

    if (!input || !preview) return;

    input.addEventListener('change', function (event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;

        removeInput.value = '0';
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            wrapper.style.display = 'inline-block';
        };
        reader.readAsDataURL(file);
    });

    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            preview.src = '';
            wrapper.style.display = 'none';
            input.value = '';
            removeInput.value = '1';
        });
    }
});
</script>
