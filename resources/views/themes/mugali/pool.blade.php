@extends('themes.mugali.layouts.app')

@section('content')
    @php
        $headerImage = media_url($localAmenitySectionSetting->header_image ?? null, 'themes/mugali/img/banner/11.jpg');
        $mainImage = media_url($aboutSectionSetting->main_image ?? null, 'themes/mugali/img/spa/1.jpg');
        $extraTitle = method_exists($restaurantExtraTextSectionSetting, 't')
            ? $restaurantExtraTextSectionSetting->t('title')
            : ($restaurantExtraTextSectionSetting->title ?? '');
        $extraDescription = method_exists($restaurantExtraTextSectionSetting, 't')
            ? $restaurantExtraTextSectionSetting->t('description')
            : ($restaurantExtraTextSectionSetting->description ?? '');
        $bottomSectionTitle = method_exists($secondaryExtraSectionSetting, 't')
            ? $secondaryExtraSectionSetting->t('title')
            : ($secondaryExtraSectionSetting->title ?? '');
        $bottomSectionDescription = method_exists($secondaryExtraSectionSetting, 't')
            ? $secondaryExtraSectionSetting->t('description')
            : ($secondaryExtraSectionSetting->description ?? '');
        $bottomSectionImages = collect([
            media_url($secondaryExtraSectionSetting->main_image ?? null),
            media_url($secondaryExtraSectionSetting->overlay_image ?? null),
        ])->filter()->values();
        $extraImages = collect([
            media_url($restaurantExtraTextSectionSetting->main_image ?? null),
            media_url($restaurantExtraTextSectionSetting->overlay_image ?? null),
            media_url($restaurantExtraTextSectionSetting->third_image ?? null),
        ])->filter()->values();
        $lead = method_exists($aboutSectionSetting, 't')
            ? $aboutSectionSetting->t('lead')
            : ($aboutSectionSetting->lead ?? '');
        $description = method_exists($aboutSectionSetting, 't')
            ? $aboutSectionSetting->t('description')
            : ($aboutSectionSetting->description ?? '');
        $items = collect($localComodites ?? [])->values();
        $featureItems = $items->take(3);
        $galleryItems = $items->slice(3, 2)->values();
    @endphp

    <section class="banner-header full-height valign bg-img" data-overlay-dark="4" data-background="{{ $headerImage }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 text-center">
                    <div class="subtitle">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('subtitle') : ($localAmenitySectionSetting->subtitle ?? '') }}
                    </div>
                    <div class="title mb-0">
                        {{ method_exists($localAmenitySectionSetting, 't') ? $localAmenitySectionSetting->t('title') : ($localAmenitySectionSetting->title ?? 'Piscine') }}
                    </div>
                    <!-- <div class="post mt-20 justify-content-center">
                        <div class="date-comment"><i class="fa-light fa-water-ladder"></i> Espace piscine</div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>

    <section class="post section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-60">
                    <div class="section-subtitle">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('small_title') : ($aboutSectionSetting->small_title ?? 'A propos de la piscine') }}
                    </div>
                    <div class="section-title">
                        {{ method_exists($aboutSectionSetting, 't') ? $aboutSectionSetting->t('title') : ($aboutSectionSetting->title ?? 'La Piscine') }}
                    </div>
                    @if(!empty($description))
                        <p class="mb-30">{!! $description !!}</p>
                    @endif
                    <img src="{{ $mainImage }}" class="rounded-2 img-fluid" alt="">
                </div>

                <div class="col-lg-10 mb-30">
                    <h3>{{ $extraTitle }}</h3>
                    <p class="mb-30">{!! $extraDescription !!}</p>
                    @if($extraImages->isNotEmpty())
                        <div class="row">
                            @foreach($extraImages as $extraImage)
                                <div class="col-lg-4 col-md-12">
                                    <img src="{{ $extraImage }}" class="mb-30 rounded-2" alt="{{ $extraTitle ?: 'Piscine' }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if(!empty($bottomSectionTitle) || !empty($bottomSectionDescription) || $bottomSectionImages->isNotEmpty())
                    <div class="col-lg-10 mb-60">
                        @if(!empty($bottomSectionTitle))
                            <h3>{{ $bottomSectionTitle }}</h3>
                        @endif
                        @if(!empty($bottomSectionDescription))
                            <p class="mb-30">{!! $bottomSectionDescription !!}</p>
                        @endif
                        @if($bottomSectionImages->isNotEmpty())
                            <div class="row">
                                @foreach($bottomSectionImages as $bottomSectionImage)
                                    <div class="col-lg-6 col-md-12">
                                        <img src="{{ $bottomSectionImage }}" class="mb-30 rounded-2" alt="{{ $bottomSectionTitle ?: 'Piscine' }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

               
            </div>
        </div>
    </section>
@endsection