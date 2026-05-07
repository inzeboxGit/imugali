@extends('themes.mugali.layouts.app')

@section('content')
@php
    $locale = app()->getLocale();
    $heroImage = media_url($heroSetting->background_image ?? null, 'themes/mugali/img/banner/11.jpg');
    $heroButtonLink = !empty($heroSetting->button_link ?? null) ? $heroSetting->button_link : route('appartements.index');
    $heroButtonTarget = $heroSetting->button_target ?? '_self';
    $heroButtonLabels = [
        'fr' => 'Découvrir Le Domaine',
        'en' => 'Discover The Estate',
        'de' => 'Entdecken Sie das Anwesen',
        'it' => 'Scopri la Tenuta',
    ];
    $heroButtonLabel = $heroButtonLabels[$locale] ?? $heroButtonLabels['en'];
    $aboutMain = media_url($aboutSectionSetting->main_image ?? null, 'themes/mugali/img/spa/12.jpg');
    $aboutSmallTitle = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('small_title') ?: 'À PROPOS DE I MUGALI')
        : ($aboutSectionSetting->small_title ?? 'À PROPOS DE I MUGALI');
    $aboutTitle = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('title') ?: 'UN DOMAINE AU CŒUR DE LA NATURE')
        : ($aboutSectionSetting->title ?? 'UN DOMAINE AU CŒUR DE LA NATURE');
    $aboutLead = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('lead') ?: "")
        : ($aboutSectionSetting->lead ?? "");
    $aboutDescription = method_exists($aboutSectionSetting, 't')
        ? ($aboutSectionSetting->t('description') ?: "Entre les sentiers du maquis, la proximité de la plage de Saleccia et les moments de partage à l’auberge, chaque journée s’organise librement, au rythme de vos envies.")
        : ($aboutSectionSetting->description ?? "Entre les sentiers du maquis, la proximité de la plage de Saleccia et les moments de partage à l’auberge, chaque journée s’organise librement, au rythme de vos envies.");
    $apartmentsSubtitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('subtitle') ?: 'Expérience hôtelière')
        : ($appartmentPageSetting->subtitle ?? 'Expérience hôtelière');
    $apartmentsTitle = method_exists($appartmentPageSetting, 't')
        ? ($appartmentPageSetting->t('title') ?: 'Nos appartements')
        : ($appartmentPageSetting->title ?? 'Nos appartements');
    $about2Main = media_url($about2SectionSetting->main_image ?? null, 'themes/mugali/img/spa/12.jpg');
    $about2SmallTitle = method_exists($about2SectionSetting, 't')
        ? ($about2SectionSetting->t('small_title') ?: '')
        : ($about2SectionSetting->small_title ?? '');
    $about2Title = method_exists($about2SectionSetting, 't')
        ? ($about2SectionSetting->t('title') ?: '')
        : ($about2SectionSetting->title ?? '');
    $about2Description = method_exists($about2SectionSetting, 't')
        ? ($about2SectionSetting->t('description') ?: '')
        : ($about2SectionSetting->description ?? '');
@endphp
<section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $heroImage }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <div class="subtitle">{{ method_exists($heroSetting, 't') ? $heroSetting->t('small_title') : ($heroSetting->small_title ?? 'Expérience hôtelière') }}</div>
                <div class="title">{{ method_exists($heroSetting, 't') ? $heroSetting->t('title') : ($heroSetting->title ?? 'Residence Mugali') }}</div>
                <div class="mt-20"></div>
                <!-- <a href="about.html" class="button-3 mb-15">About Hotel</a> -->
                <a href="{{ $heroButtonLink }}" class="button-3 mb-15" target="{{ $heroButtonTarget }}"
                    @if($heroButtonTarget === '_blank') rel="noopener" @endif>
                    {{ $heroButtonLabel }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 mb-15">
                <div class="section-subtitle">{{ $aboutSmallTitle }}</div>
                <div class="section-title">{{ $aboutTitle }}</div>
                <p class="mb-15">{!! $aboutDescription !!}</p>
                <a href="{{ !empty($aboutSectionSetting->button_link ?? null) ? $aboutSectionSetting->button_link : route('restaurant.index') }}" class="button-3 mb-15">{{ !empty($aboutSectionSetting->signature ?? null) ? (method_exists($aboutSectionSetting, 't') ? ($aboutSectionSetting->t('signature') ?: $aboutSectionSetting->signature) : $aboutSectionSetting->signature) : 'Découvrir Le Domaine' }}</a>
                <!-- @if(!empty($siteSetting->phone_primary ?? null))
                    <div class="phone">
                        <a href="tel:{{ preg_replace('/\s+/', '', (string) $siteSetting->phone_primary) }}">
                            <i class="fa-light fa-phone"></i>{{ $siteSetting->phone_primary }}
                        </a>
                    </div>
                @endif -->
            </div>
            <!-- offset-lg-1 mt-45-->
            <div class="col-lg-7 col-md-12 mb-20 ">
                <div style="aspect-ratio: 4 / 3; overflow: hidden; border-radius: 8px;">
                    <img src="{{ $aboutMain }}" class="rounded-2" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Video Ambiance -->
@include('themes.mugali.partials.home.video-ambiance', [
    'homeVideoSetting' => $homeVideoSetting ?? null,
])


<!-- About 2 -->
@if(!empty($about2Title) || !empty($about2Description))
<section class="about section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 mb-20">
                <div style="aspect-ratio: 4 / 3; overflow: hidden; border-radius: 8px;">
                    <img src="{{ $about2Main }}" class="rounded-2" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-5 col-md-12 mb-15">
                @if(!empty($about2SmallTitle))<div class="section-subtitle">{{ $about2SmallTitle }}</div>@endif
                @if(!empty($about2Title))<div class="section-title">{{ $about2Title }}</div>@endif
                @if(!empty($about2Description))<p class="mb-15">{!! $about2Description !!}</p>@endif
                @if(!empty($about2SectionSetting->signature ?? null))
                <a href="{{ !empty($about2SectionSetting->button_link ?? null) ? $about2SectionSetting->button_link : route('restaurant.index') }}" class="button-3 mb-15">{{ method_exists($about2SectionSetting, 't') ? ($about2SectionSetting->t('signature') ?: $about2SectionSetting->signature) : $about2SectionSetting->signature }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endif


<!-- Activities & Excursions -->
@include('themes.mugali.partials.activities.pricing', [
    'localComodites' => $localComodites ?? collect(),
    'localAmenitySectionSetting' => $localAmenitySectionSetting ?? null,
    'installations' => $installations ?? collect(),
    'installationSectionSetting' => $installationSectionSetting ?? null,
])

@include('partials.home.testimonials')

<!-- Home Rooms (Appartements) -->
<!-- @include('themes.mugali.partials.home.rooms', [
    'apartmentsSubtitle' => $apartmentsSubtitle,
    'apartmentsTitle' => $apartmentsTitle,
    'homeRooms' => $homeRooms ?? collect(),
]) -->

<!-- actualités -->
<section class="blog1 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle">{{ method_exists($newsPageSetting ?? null, 't') ? ($newsPageSetting->t('subtitle') ?: ($newsPageSetting->subtitle ?? 'Dernières nouvelles')) : ($newsPageSetting->subtitle ?? 'Dernières nouvelles') }}</div>
                <div class="section-title">{{ method_exists($newsPageSetting ?? null, 't') ? ($newsPageSetting->t('title') ?: ($newsPageSetting->title ?? 'Actualités')) : ($newsPageSetting->title ?? 'Actualités') }}</div>
            </div>
        </div>
        <div class="row">
            @forelse(($homeNews ?? collect()) as $item)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img">
                            <img src="{{ media_url($item->cover_image ?? null, 'themes/mugali/img/blog/1.jpg') }}" class="img-fluid" alt="">
                            <div class="cat">{{ $item->published_at?->format('d M Y') }}</div>
                        </div>
                        <div class="cont">
                            <h4><a href="{{ route('news.show', $item->slug) }}" class="redBrown">{{ method_exists($item, 't') ? $item->t('title') : $item->title }}</a></h4>
                            <p>{!! \Illuminate\Support\Str::limit(strip_tags(method_exists($item, 't') ? $item->t('excerpt') : ($item->excerpt ?? '')), 50) !!}</p>
                            <div class="cat mt-2 redBrown">{{ $item->published_at?->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">Aucune actualité.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- before footer -->
@include('themes.mugali.partials.home.before-footer', [
    'beforeFooterSetting' => $beforeFooterSetting ?? null,
])

@endsection
