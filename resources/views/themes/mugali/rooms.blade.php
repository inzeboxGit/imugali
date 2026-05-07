@extends('themes.mugali.layouts.app')

@section('content')
@php
    $headerImage = media_url($appartmentPageSetting->header_image ?? null, 'themes/mugali/img/banner/11.jpg');
@endphp
<section class="rooms banner-header bg-img bg-fixed" data-overlay-dark="5" data-background="{{ $headerImage }}">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="subtitle">{{ method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('subtitle') : ($appartmentPageSetting->subtitle ?? 'Expérience hôtelière') }}</div>
                <div class="title">{{ method_exists($appartmentPageSetting, 't') ? $appartmentPageSetting->t('title') : ($appartmentPageSetting->title ?? 'Nos appartements') }}</div>
            </div>
        </div>
    </div>
</section>

<section class="rooms blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            @forelse(($rooms ?? collect()) as $room)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img">
                            <img src="{{ media_url($room->main_image ?? null, 'themes/mugali/img/restaurant/2.jpg') }}" class="img-fluid" alt="">
                            <div class="cat">{{ $room->price_per_night ? number_format($room->price_per_night, 0).' €/nuit' : 'Tarif sur demande' }}</div>
                        </div>
                        <div class="cont">
                            <h4><a href="{{ route('rooms.show', $room->slug) }}">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</a></h4>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(method_exists($room, 't') ? $room->t('description') : ($room->description ?? '')), 120) }}</p>
                            <a href="{{ route('rooms.show', $room->slug) }}" class="button-3">Voir détails</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">Aucun appartement publié.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
