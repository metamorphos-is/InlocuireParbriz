@php
    $selectedCategory = old('category', $selected ?? request('serviciu'));
    $compact = $compact ?? false;
    $area = old('area_type', 'bucuresti');
@endphp
<form method="POST" action="{{ route('lead.store') }}" class="ee-form @if($compact) ee-form--compact @endif" novalidate data-lead-form>
    @csrf

    <div class="ee-hp" aria-hidden="true">
        <label for="website">Nu completa acest câmp</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>

    @if ($errors->any())
        <div class="ee-alert ee-alert--error" role="alert">
            Te rugăm să corectezi câmpurile marcate mai jos.
        </div>
    @endif

    <fieldset class="ee-fieldset">
        <legend>Date de contact</legend>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="ee-label" for="name">Nume <span aria-hidden="true">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" @class(['form-control', 'is-invalid' => $errors->has('name')]) autocomplete="name" required>
                @error('name')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="phone">Telefon <span aria-hidden="true">*</span></label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" @class(['form-control', 'is-invalid' => $errors->has('phone')]) autocomplete="tel" inputmode="tel" placeholder="07xx xxx xxx" required>
                @error('phone')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="email">Email <small>(opțional)</small></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" @class(['form-control', 'is-invalid' => $errors->has('email')]) autocomplete="email">
                @error('email')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="category">Serviciu <span aria-hidden="true">*</span></label>
                <select id="category" name="category" @class(['form-select', 'is-invalid' => $errors->has('category')]) required>
                    <option value="">Alege serviciul…</option>
                    @foreach (config('inlocuireparbriz.services') as $slug => $s)
                        <option value="{{ $slug }}" @selected($selectedCategory === $slug)>{{ $s['nav_label'] ?? $s['name'] }}</option>
                    @endforeach
                </select>
                @error('category')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="ee-fieldset">
        <legend>Date mașină</legend>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="ee-label" for="vehicle_brand">Marcă</label>
                <input type="text" id="vehicle_brand" name="vehicle_brand" value="{{ old('vehicle_brand') }}" @class(['form-control', 'is-invalid' => $errors->has('vehicle_brand')]) placeholder="ex. Volkswagen" autocomplete="off">
                @error('vehicle_brand')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="ee-label" for="vehicle_model">Model</label>
                <input type="text" id="vehicle_model" name="vehicle_model" value="{{ old('vehicle_model') }}" @class(['form-control', 'is-invalid' => $errors->has('vehicle_model')]) placeholder="ex. Golf" autocomplete="off">
                @error('vehicle_model')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="ee-label" for="vehicle_year">An</label>
                <input type="number" id="vehicle_year" name="vehicle_year" value="{{ old('vehicle_year') }}" @class(['form-control', 'is-invalid' => $errors->has('vehicle_year')]) min="1985" max="2100" inputmode="numeric" placeholder="ex. 2018">
                @error('vehicle_year')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="vehicle_vin">Serie șasiu (VIN) <small>(opțional)</small></label>
                <input type="text" id="vehicle_vin" name="vehicle_vin" value="{{ old('vehicle_vin') }}" @class(['form-control', 'is-invalid' => $errors->has('vehicle_vin')]) maxlength="32" autocomplete="off">
                @error('vehicle_vin')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="glass_type">Tip geam</label>
                <select id="glass_type" name="glass_type" @class(['form-select', 'is-invalid' => $errors->has('glass_type')])>
                    <option value="">Alege…</option>
                    @foreach (config('inlocuireparbriz.glass_types') as $key => $label)
                        <option value="{{ $key }}" @selected(old('glass_type') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('glass_type')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
        </div>
    </fieldset>

    <fieldset class="ee-fieldset">
        <legend>Dotări pe care le cunoști</legend>
        <p class="ee-help mb-2">Bifează ce știi. Dacă nu ești sigur, lasă nebifat sau alege „Nu știu”.</p>
        <div class="row g-2">
            @foreach (config('inlocuireparbriz.glass_features') as $key => $label)
                <div class="col-sm-6">
                    <div class="ee-check">
                        <input type="checkbox" id="feat_{{ $key }}" name="glass_features[]" value="{{ $key }}" @checked(collect(old('glass_features', []))->contains($key))>
                        <label for="feat_{{ $key }}">{{ $label }}</label>
                    </div>
                </div>
            @endforeach
            <div class="col-sm-6">
                <div class="ee-check">
                    <input type="checkbox" id="feat_nu_stiu" name="glass_features[]" value="nu_stiu" @checked(collect(old('glass_features', []))->contains('nu_stiu'))>
                    <label for="feat_nu_stiu">Nu știu</label>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="ee-fieldset">
        <legend>Locație</legend>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="ee-label" for="area_type">Zonă <span aria-hidden="true">*</span></label>
                <select id="area_type" name="area_type" @class(['form-select', 'is-invalid' => $errors->has('area_type')]) required data-area-type>
                    <option value="bucuresti" @selected($area === 'bucuresti')>București</option>
                    <option value="ilfov" @selected($area === 'ilfov')>Ilfov</option>
                    <option value="alt_oras" @selected($area === 'alt_oras')>Alt oraș din România</option>
                </select>
                @error('area_type')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6" data-sector-wrap>
                <label class="ee-label" for="sector">Sector</label>
                <select id="sector" name="sector" @class(['form-select', 'is-invalid' => $errors->has('sector')]) data-sector-select>
                    <option value="">Alege sectorul…</option>
                    @foreach (config('inlocuireparbriz.sectors') as $n)
                        <option value="{{ $n }}" @selected((string) old('sector', request('sector')) === (string) $n)>Sectorul {{ $n }}</option>
                    @endforeach
                </select>
                @error('sector')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6" data-locality-wrap hidden>
                <label class="ee-label" for="locality" data-locality-label data-label-ilfov="Localitate Ilfov" data-label-other="Oraș / localitate">Localitate Ilfov</label>
                <input type="text" id="locality" name="locality" value="{{ old('locality', request('oras')) }}" @class(['form-control', 'is-invalid' => $errors->has('locality')]) placeholder="ex. Voluntari, Otopeni…" data-placeholder-ilfov="ex. Voluntari, Otopeni…" data-placeholder-other="ex. Cluj-Napoca, Iași, Brașov…" maxlength="120">
                <div class="ee-help">Îți confirmăm disponibilitatea în zona ta odată cu oferta.</div>
                @error('locality')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="ee-label" for="service_location_type">Unde preferi montajul</label>
                <select id="service_location_type" name="service_location_type" @class(['form-select', 'is-invalid' => $errors->has('service_location_type')])>
                    <option value="">Alege…</option>
                    @foreach (config('inlocuireparbriz.location_types') as $key => $label)
                        <option value="{{ $key }}" @selected(old('service_location_type') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset class="ee-fieldset">
        <legend>Detalii</legend>
        <div class="row g-3">
            <div class="col-12">
                <label class="ee-label" for="description">Descrie problema <span aria-hidden="true">*</span></label>
                <textarea id="description" name="description" rows="{{ $compact ? 3 : 5 }}" @class(['form-control', 'is-invalid' => $errors->has('description')]) placeholder="Ce s-a întâmplat, de când, dacă ai fotografii la îndemână…" required>{{ old('description') }}</textarea>
                <div class="ee-help">Poți trimite fotografiile pe WhatsApp după ce te contactăm, dacă nu le poți încărca acum.</div>
                @error('description')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <input type="hidden" name="urgency" value="0">
                <div class="ee-check ee-check--urgent">
                    <input type="checkbox" id="urgency" name="urgency" value="1" @checked(old('urgency'))>
                    <label for="urgency"><strong>Urgent</strong> — am nevoie de intervenție cât mai repede</label>
                </div>
            </div>
            <div class="col-12">
                <div class="ee-check">
                    <input type="checkbox" id="consent" name="consent" value="1" @checked(old('consent')) @class(['is-invalid' => $errors->has('consent')]) required>
                    <label for="consent">Sunt de acord ca Înlocuire Parbriz să îmi prelucreze datele pentru a mă contacta în legătură cu această cerere, conform <a href="{{ route('privacy') }}" target="_blank" rel="noopener">politicii de confidențialitate</a>. <span aria-hidden="true">*</span></label>
                </div>
                @error('consent')<div class="ee-error">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <button type="submit" class="ee-btn ee-btn--amber ee-btn--lg">Trimite cererea @include('partials.icon', ['name' => 'arrow', 'size' => 20])</button>
            </div>
        </div>
    </fieldset>
</form>
