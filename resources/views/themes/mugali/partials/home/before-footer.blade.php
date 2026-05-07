@php
    $locale = app()->getLocale();
    $bfHasTranslations = isset($beforeFooterSetting) && method_exists($beforeFooterSetting, 't');
    $bfSubtitle = $bfHasTranslations
        ? ($beforeFooterSetting->t('subtitle', $locale) ?: ($beforeFooterSetting->subtitle ?? ''))
        : ($beforeFooterSetting->subtitle ?? '');
    $bfTitle = $bfHasTranslations
        ? ($beforeFooterSetting->t('title', $locale) ?: ($beforeFooterSetting->title ?? ''))
        : ($beforeFooterSetting->title ?? '');
    $bfImageSrc = media_url($beforeFooterSetting->header_image ?? null, null);
@endphp

@if(!empty($bfSubtitle) || !empty($bfTitle) || !empty($bfImageSrc))
<section class="before-footer"
    @if(!empty($bfImageSrc))
        data-background="{{ $bfImageSrc }}"
    @endif
    style="
        @if(!empty($bfImageSrc)) background-image: url('{{ $bfImageSrc }}'); background-size: cover; background-position: center; @endif
        height: 452px;
        display: flex;
        align-items: center;
    "
>
    <div class="container w-100">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-md-10 col-12">
                @if(!empty($bfSubtitle))
                    <div class="section-subtitle">{{ $bfSubtitle }}</div>
                @endif
                @if(!empty($bfTitle))
                    <div class="section-title brownColor">{{ $bfTitle }}</div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
@media (max-width: 767px) {
    .before-footer {
        height: auto !important;
        min-height: 260px;
        padding: 60px 0;
    }
}
@media (min-width: 768px) and (max-width: 991px) {
    .before-footer {
        height: 340px !important;
    }
}
</style>
@endif
