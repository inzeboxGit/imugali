@extends('layouts.app')

@section('content')
<main>
    @php
    $locale = app()->getLocale();
    $labels = [
        'fr' => [
            'address' => 'Adresse', 'email' => 'Adresse email', 'phone' => 'Téléphone',
            'touch' => 'Contactez-nous', 'name' => 'Prénom', 'lastname' => 'Nom', 'message' => 'Message',
            'human' => 'Êtes-vous humain ? 3 + 1 =', 'submit' => 'Envoyer',
        ],
        'en' => [
            'address' => 'Address', 'email' => 'Email address', 'phone' => 'Telephone',
            'touch' => 'Get in Touch', 'name' => 'Name', 'lastname' => 'Last name', 'message' => 'Message',
            'human' => 'Are you human? 3 + 1 =', 'submit' => 'Submit',
        ],
        'de' => [
            'address' => 'Adresse', 'email' => 'E-Mail-Adresse', 'phone' => 'Telefon',
            'touch' => 'Kontaktieren Sie uns', 'name' => 'Vorname', 'lastname' => 'Nachname', 'message' => 'Nachricht',
            'human' => 'Sind Sie ein Mensch? 3 + 1 =', 'submit' => 'Senden',
        ],
        'it' => [
            'address' => 'Indirizzo', 'email' => 'Indirizzo email', 'phone' => 'Telefono',
            'touch' => 'Contattaci', 'name' => 'Nome', 'lastname' => 'Cognome', 'message' => 'Messaggio',
            'human' => 'Sei umano? 3 + 1 =', 'submit' => 'Invia',
        ],
    ];
    $ui = $labels[$locale] ?? $labels['en'];

    $primaryPhone = $siteSetting->phone_primary ?? '';
    $secondaryPhone = $siteSetting->phone_secondary ?? '';
    $primaryPhoneHref = preg_replace('/\s+/', '', (string) $primaryPhone);
    $secondaryPhoneHref = preg_replace('/\s+/', '', (string) $secondaryPhone);
    
    $contactAddress = method_exists($siteSetting, 't')
        ? $siteSetting->t('address')
        : ($siteSetting->address ?? '');
    $contactAddress = $contactAddress ?: "3 place de l'Eglise, 20220 SANTA REPARATA DI BALAGNA, France";

    $mapLatitude = $contactPageSetting->map_latitude ?? 42.6043096;
    $mapLongitude = $contactPageSetting->map_longitude ?? 8.9295210;
    $mapSrc = 'https://www.google.com/maps?q=' . $mapLatitude . ',' . $mapLongitude . '&z=15&output=embed';

    $settingTranslation = function (string $field, string $default) use ($contactPageSetting, $locale) {
        if ($locale === 'fr') {
            return $contactPageSetting->{$field} ?? $default;
        }

        if (method_exists($contactPageSetting, 'translations') && $contactPageSetting->relationLoaded('translations')) {
            $translatedValue = $contactPageSetting->translations
                ->first(fn ($item) => $item->locale === $locale && $item->field === $field)?->value;

            if (!empty($translatedValue)) {
                return $translatedValue;
            }
        }

        return $default;
    };

    $firstNameLabel = $settingTranslation('select_room_label', $ui['name']);
    $lastNameLabel = $settingTranslation('adults_label', $ui['lastname']);
    $phoneLabel = $settingTranslation('info_booking_label', $ui['phone']);
    $messageLabel = $settingTranslation('children_label', $ui['message']);
    $submitLabel = $settingTranslation('book_now_label', $ui['submit']);
    @endphp

    <!-- Elegant Page Title -->
    <div class="container mt-5 pt-5 mb-2">
        <div class="title text-center mt-4">
            <h1 class="fw-bold text-uppercase" style="color: #BD945A; font-size: 2.2rem; letter-spacing: 1px; font-family: 'Outfit', sans-serif;">{{ $ui['touch'] }}</h1>
            <div style="width: 60px; height: 2px; background-color: #BD945A; margin: 15px auto 0;"></div>
        </div>
    </div>

    <div class="container margin_120_95 pt-2">
        <div class="row justify-content-between">
            <div class="col-xl-4 col-lg-5 order-lg-2">
                <div class="contact_info">
                    <ul class="clearfix">
                        <li>
                            <i class="bi bi-geo-alt"></i>
                            <h4>{{ $ui['address'] }}</h4>
                            <div>{{ $contactAddress }}</div>
                        </li>
                        <li>
                            <i class="bi bi-envelope-paper"></i>
                            <h4>{{ $ui['email'] }}</h4>
                            @if(!empty($siteSetting->email))
                            <p><a href="mailto:{{ $siteSetting->email }}">{{ $siteSetting->email }}</a></p>
                            @else
                            <p>-</p>
                            @endif
                        </li>
                        <li>
                            <i class="bi bi-telephone"></i>
                            <h4>{{ $ui['phone'] }}</h4>
                            <div>
                                @if(!empty($primaryPhone))
                                <a href="tel:{{ $primaryPhoneHref }}">{{ $primaryPhone }}</a>
                                @endif
                                @if(!empty($secondaryPhone))
                                <br><a href="tel:{{ $secondaryPhoneHref }}">{{ $secondaryPhone }}</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 order-lg-1">
                <h3 class="mb-3">{{ $ui['touch'] }}</h3>
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div id="message-contact"></div>
                <form method="post" action="{{ route('contact.send') }}" id="contact_form_laravel" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="name_contact" name="name_contact"
                                    value="{{ old('name_contact') }}" placeholder="{{ $firstNameLabel }}">
                                <label for="name_contact">{{ $firstNameLabel }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="lastname_contact" name="lastname_contact"
                                    value="{{ old('lastname_contact') }}" placeholder="{{ $lastNameLabel }}">
                                <label for="lastname_contact">{{ $lastNameLabel }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="email" id="email_contact" name="email_contact"
                                    value="{{ old('email_contact') }}" placeholder="{{ $ui['email'] }}">
                                <label for="email_contact">{{ $ui['email'] }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="phone_contact" name="phone_contact"
                                    value="{{ old('phone_contact') }}" placeholder="{{ $phoneLabel }}">
                                <label for="phone_contact">{{ $phoneLabel }}</label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                    <div class="form-floating mb-4">
                        <textarea class="form-control" placeholder="{{ $messageLabel }}" id="message_contact"
                            name="message_contact">{{ old('message_contact') }}</textarea>
                        <label for="message_contact">{{ $messageLabel }}</label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input class="form-control" type="text" id="verify_contact" name="verify_contact"
                                    value="{{ old('verify_contact') }}" placeholder="{{ $ui['human'] }}">
                                <label for="verify_contact">{{ $ui['human'] }}</label>
                            </div>
                        </div>
                    </div>
                    <p class="mt-3"><input type="submit" value="{{ $submitLabel }}" class="btn_1 outline"
                            id="submit-contact"></p>
                </form>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!--/container -->

    <div class="map_contact">
        <iframe src="{{ $mapSrc }}" width="600"
            height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <!--/map_contact -->

</main>
@endsection
