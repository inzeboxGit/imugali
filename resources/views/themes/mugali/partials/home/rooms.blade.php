<section class="blog1 section-padding bg-lightbrown">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-20">
                <div class="section-subtitle">{{ $apartmentsSubtitle }}</div>
                <div class="section-title">{{ $apartmentsTitle }}</div>
            </div>
        </div>
        <div class="row">
            @forelse(($homeRooms ?? collect()) as $room)
                <div class="col-lg-4 col-md-6 mb-30">
                    <div class="item">
                        <div class="img">
                            <img src="{{ media_url($room->main_image ?? null, 'themes/mugali/img/restaurant/1.jpg') }}" class="img-fluid" alt="">
                            <div class="cat">Appartement</div>
                        </div>
                        <div class="cont">
                            <h4><a href="{{ route('rooms.show', $room->slug) }}">{{ method_exists($room, 't') ? $room->t('title') : $room->title }}</a></h4>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags(method_exists($room, 't') ? $room->t('description') : ($room->description ?? '')), 120) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">Aucun appartement publié.</div>
            @endforelse
        </div>
    </div>
</section>