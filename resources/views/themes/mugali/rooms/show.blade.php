@extends('themes.mugali.layouts.app')

@section('content')
@php
    $headerImage = media_url($room->main_image ?? null, 'themes/mugali/img/restaurant/3.jpg');
@endphp
<section class="banner-header full-height valign bg-img" data-overlay-dark="5" data-background="{{ $headerImage }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 text-center">
                <div class="subtitle">Expérience hôtelière</div>
                <div class="title">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
            </div>
        </div>
    </div>
</section>

<section class="page-details section-padding">
    <div class="container">
        <div class="row mb-30">
            <div class="col-md-12">
                <div class="section-title">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</div>
                <p>{!! nl2br(e(method_exists($room, 't') ? $room->t('description') : ($room->description ?? ''))) !!}</p>
            </div>
        </div>

        <div class="row mb-30">
            @forelse($room->amenities as $amenity)
                <div class="col-md-4 mb-3">
                    <div class="menu-info">
                        <h5>{{ method_exists($amenity, 't') ? $amenity->t('title') : $amenity->title }}</h5>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">Aucune commodité renseignée.</div>
            @endforelse
        </div>

        @if(!empty($room->gallery))
            <div class="row">
                @foreach($room->gallery as $image)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <img src="{{ media_url($image, 'themes/mugali/img/restaurant/4.jpg') }}" class="img-fluid rounded-2" alt="">
                    </div>
                @endforeach
            </div>
        @endif

        <div class="row mt-4">
            <div class="col-12"><a href="{{ route('appartements.index') }}" class="button-3">Retour aux appartements</a></div>
        </div>
    </div>
</section>

@if(($similarRooms ?? collect())->isNotEmpty())
<section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row"><div class="col-md-12 text-center mb-20"><div class="section-subtitle">Suggestions</div><div class="section-title">Appartements similaires</div></div></div>
        <div class="row">
            @foreach($similarRooms as $similar)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img"><img src="{{ media_url($similar->main_image ?? null, 'themes/mugali/img/restaurant/5.jpg') }}" class="img-fluid" alt=""></div>
                        <div class="cont">
                            <h4><a href="{{ route('rooms.show', $similar->slug) }}">{{ method_exists($similar, 't') ? $similar->t('title') : $similar->title }}</a></h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
