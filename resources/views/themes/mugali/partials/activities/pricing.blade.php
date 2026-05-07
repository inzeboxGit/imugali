@php
    $activities = collect($localComodites ?? [])->take(3)->values();

    $fallbackImages = [
        theme_asset('img/spa/1.jpg'),
        theme_asset('img/spa/2.jpg'),
        theme_asset('img/spa/3.jpg'),
    ];

    $fallbackIcons = [
        'fa-thin fa-person-hiking',
        'fa-thin fa-horse-saddle',
        'fa-thin fa-mug-hot',
    ];

    $fallbackTitles = [
        'Randonnée',
        'Piscine',
        'Détente',
    ];

    $subtitle = (is_object($localAmenitySectionSetting ?? null) && method_exists($localAmenitySectionSetting, 't'))
        ? ($localAmenitySectionSetting->t('subtitle') ?: 'Nos Activités...')
        : (($localAmenitySectionSetting->subtitle ?? null) ?: 'Nos Activités...');

    $title = (is_object($localAmenitySectionSetting ?? null) && method_exists($localAmenitySectionSetting, 't'))
        ? ($localAmenitySectionSetting->t('title') ?: 'Activités & Excursions')
        : (($localAmenitySectionSetting->title ?? null) ?: 'Activités & Excursions');

    $contactEmail = $siteSetting->email ?? 'info@hotels.com';

    $readMoreLabels = [
        'fr' => 'Lire Plus',
        'en' => 'Read More',
        'de' => 'Mehr lesen',
        'it' => 'Leggi di più',
    ];
    $readMoreLabel = $readMoreLabels[app()->getLocale()] ?? $readMoreLabels['fr'];
@endphp

<!-- Pricing 1 -->
<style>
    .pricing1 .pricing .item .img {
        aspect-ratio: 2 / 3;
        overflow: hidden;
    }

    .pricing1 .pricing .item .img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pricing1 .pricing .item .cont .icon img {
        width: 102px;
        /* height: 34px; */
        object-fit: contain;
    }
</style>
<section class="pricing1 section-padding bg-lightbrown" style="background-color: #F4EFED;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle">{{ $subtitle }}</div>
                <div class="section-title" style="color:#b55a3d">{{ $title }}</div>
            </div>
        </div>
        <div class="row justify-content-center g-0">
            <div class="col-12 pricing">
                @for($i = 0; $i < 3; $i++)
                    @php
                        $activity = $activities->get($i);
                        $activityTitle = $activity
                            ? (method_exists($activity, 't') ? ($activity->t('title') ?: $activity->title) : $activity->title)
                            : $fallbackTitles[$i];
                        $activityDesc = $activity
                            ? (method_exists($activity, 't') ? ($activity->t('description') ?: $activity->description) : $activity->description)
                            : 'Découvrez cette activité pendant votre séjour.';
                        $activityMeta = $activity
                            ? (method_exists($activity, 't') ? ($activity->t('small_title') ?: $activity->small_title) : $activity->small_title)
                            : 'Activité';
                        $activityImage = media_url($activity?->image_path, $fallbackImages[$i]);
                    @endphp
                    <div class="item {{ $i === 1 ? 'active' : '' }}">
                        <div class="img">
                            <img src="{{ $activityImage }}" class="img-fluid" alt="{{ $activityTitle }}" />
                            <div class="title">{{ $activityTitle }}</div>
                            <div class="overlay"></div>
                        </div>
                        <div class="flex-column cont">
                            <div class="cont-hover">
                                <div class="icon">
                                    @if($i === 1)
                                        <img src="{{ theme_asset('img/dosdan.png') }}" alt="Piscine">
                                    @else
                                        <i class="{{ $fallbackIcons[$i] }}"></i>
                                    @endif
                                </div>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($activityDesc), 60) }}</p>
                                @if(!empty($activity?->price))
                                    <div class="price"style="color:#b55a3d;">{{ $activity->price }}</div>
                                @endif
                                @if(!empty($activity?->link_url))
                                    <a href="{{ $activity->link_url }}" class="mt-15" style="display:inline-block; padding:4px 34px; background-color:rgb(189, 148, 90); color:#fff; border-radius:50px; font-size:0.8rem; letter-spacing:1px; text-transform:uppercase;">
                                        {{ $readMoreLabel }}
                                    </a>
                                @elseif(!empty($activityMeta))
                                    <div class="price" ><span>{{ $activityMeta }}</span></div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <!-- phone section -->
        <div class="row">
            <div class="col-md-12 text-center mt-30">
                <div class="section-info">
                    <div class="tag">Questions</div>
                    <div class="desc">
                        Vous avez des questions ? Envoyez nous un email à :
                        <a href="mailto:{{ $contactEmail }}" class="text-decoration-line-bottom">{{ $contactEmail }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('themes.mugali.partials.activities.installations', [
    'installations' => $installations ?? collect(),
    'installationSectionSetting' => $installationSectionSetting ?? null,
])