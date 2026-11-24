<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\CitySector;
use App\Models\Lead;
use App\Services\Notifications\LeadNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class LeadController extends Controller
{
    public function create(Request $request)
    {
        $services = config('inlocuireparbriz.services');
        $selected = $request->query('serviciu');

        return view('pages.lead', [
            'services' => $services,
            'selected' => array_key_exists((string) $selected, $services) ? $selected : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $services = array_keys(config('inlocuireparbriz.services'));
        $sectors = config('inlocuireparbriz.sectors');
        $glassTypes = array_keys(config('inlocuireparbriz.glass_types'));
        $locationTypes = array_keys(config('inlocuireparbriz.location_types'));
        $featureKeys = array_merge(array_keys(config('inlocuireparbriz.glass_features')), ['nu_stiu']);

        // Antispam (App\Support\SpamGuard): boții primesc pagina de „mulțumim”, dar cererea nu se salvează.
        if ($verdict = \App\Support\SpamGuard::check($request)) {
            if (str_starts_with($verdict, 'error:')) {
                [$field, $message] = explode('|', substr($verdict, 6), 2);

                return back()->withErrors([$field => $message])->withInput();
            }
            \App\Support\SpamGuard::record(substr($verdict, 7), $request);

            return redirect()->route('lead.thanks');
        }
        $request->merge(['phone' => \App\Support\SpamGuard::phone($request)]);

        // Aceeași persoană a mai trimis în ultimele 30 de minute → nu dublăm cererea și notificările.
        if (Schema::hasTable('leads') && Lead::query()->where('phone', $request->input('phone'))->where('created_at', '>=', now()->subMinutes(30))->exists()) {
            \App\Support\SpamGuard::record('duplicat', $request);

            return redirect()->route('lead.thanks');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'phone' => ['required', 'string', 'regex:/^[0-9+()\s.\-]{9,20}$/'],
            'email' => ['nullable', 'email:rfc', 'max:190'],
            'category' => ['required', Rule::in($services)],
            'area_type' => ['required', Rule::in(['bucuresti', 'ilfov', 'alt_oras'])],
            'sector' => ['nullable', 'integer', Rule::in($sectors)],
            'locality' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'vehicle_brand' => ['nullable', 'string', 'max:80'],
            'vehicle_model' => ['nullable', 'string', 'max:80'],
            'vehicle_year' => ['nullable', 'integer', 'min:1985', 'max:2100'],
            'vehicle_vin' => ['nullable', 'string', 'max:32'],
            'glass_type' => ['nullable', Rule::in($glassTypes)],
            'glass_features' => ['nullable', 'array'],
            'glass_features.*' => [Rule::in($featureKeys)],
            'service_location_type' => ['nullable', Rule::in($locationTypes)],
            'urgency' => ['nullable', 'boolean'],
            'consent' => ['accepted'],
        ], [
            'name.required' => 'Te rugăm să completezi numele.',
            'phone.required' => 'Te rugăm să completezi numărul de telefon.',
            'phone.regex' => 'Numărul de telefon nu pare valid.',
            'category.required' => 'Alege serviciul de care ai nevoie.',
            'area_type.required' => 'Alege zona: București, Ilfov sau alt oraș.',
            'description.required' => 'Descrie pe scurt problema.',
            'description.min' => 'Adaugă câteva detalii (minim 10 caractere).',
            'consent.accepted' => 'Este necesar acordul pentru prelucrarea datelor.',
        ]);

        if (($data['area_type'] ?? '') === 'bucuresti' && empty($data['sector'])) {
            return back()->withErrors(['sector' => 'Alege sectorul din București.'])->withInput();
        }

        if (($data['area_type'] ?? '') === 'ilfov' && blank($data['locality'] ?? null)) {
            return back()->withErrors(['locality' => 'Scrie localitatea din Ilfov.'])->withInput();
        }

        if (($data['area_type'] ?? '') === 'alt_oras' && blank($data['locality'] ?? null)) {
            return back()->withErrors(['locality' => 'Scrie orașul sau localitatea.'])->withInput();
        }

        $data['urgency'] = (bool) ($data['urgency'] ?? false);
        $data['landing_path'] = Str::limit(parse_url((string) $request->headers->get('referer'), PHP_URL_PATH) ?: '/cerere-oferta', 250, '');

        $reference = $this->persist($data, $request);

        return redirect()->route('lead.thanks')->with('lead_reference', $reference);
    }

    public function thanks()
    {
        return view('pages.thanks');
    }

    protected function persist(array $data, Request $request): string
    {
        $ipHash = hash('sha256', $request->ip().'|'.config('app.key'));

        try {
            if (class_exists(Lead::class) && Schema::hasTable('leads')) {
                $serviceName = config("inlocuireparbriz.services.{$data['category']}.name", $data['category']);
                $city = ($data['area_type'] ?? '') === 'alt_oras'
                    ? $this->matchCity((string) ($data['locality'] ?? ''))
                    : City::query()->where('slug', config('inlocuireparbriz.city_slug', 'bucuresti'))->first();
                $sector = null;
                if (($data['area_type'] ?? '') === 'bucuresti' && ! empty($data['sector']) && $city) {
                    $sector = CitySector::query()
                        ->where('city_id', $city->id)
                        ->where('slug', 'sector-'.$data['sector'])
                        ->first();
                }

                $address = match ($data['area_type'] ?? '') {
                    'ilfov' => 'Ilfov, '.($data['locality'] ?? ''),
                    'alt_oras' => trim((string) ($data['locality'] ?? '')),
                    default => 'București, Sectorul '.($data['sector'] ?? ''),
                };

                $lead = Lead::create([
                    'category_id' => Category::query()->where('slug', 'inlocuire-parbrize')->value('id'),
                    'city_id' => $city?->id,
                    'sector_id' => $sector?->id,
                    'customer_name' => $data['name'],
                    'phone' => $data['phone'],
                    'email' => $data['email'] ?? null,
                    'address_text' => $address,
                    'vehicle_brand' => $data['vehicle_brand'] ?? null,
                    'vehicle_model' => $data['vehicle_model'] ?? null,
                    'vehicle_year' => $data['vehicle_year'] ?? null,
                    'vehicle_vin' => $data['vehicle_vin'] ?? null,
                    'glass_type' => $data['glass_type'] ?? null,
                    'glass_features' => $data['glass_features'] ?? null,
                    'service_location_type' => $data['service_location_type'] ?? null,
                    'description' => '['.$serviceName.'] '.$data['description'],
                    'urgency' => $data['urgency'],
                    'status' => 'noua',
                    'source' => 'site-public',
                    'landing_path' => $data['landing_path'],
                    'consent_at' => now(),
                    'ip_hash' => $ipHash,
                ]);

                Log::info('Lead nou salvat', ['reference' => $lead->reference, 'category' => $data['category']]);

                // Notificări (email admin + SMS confirmare client). Respectă comutatoarele din Setări;
                // o eroare de trimitere nu are voie să piardă cererea.
                try {
                    $notifier = app(LeadNotifier::class);
                    $notifier->notifyAdminNewLead($lead);
                    $notifier->notifyCustomerReceived($lead);
                } catch (Throwable $e) {
                    Log::error('Notificare lead nou eșuată', ['reference' => $lead->reference, 'error' => $e->getMessage()]);
                }

                return $lead->reference;
            }
        } catch (Throwable $e) {
            Log::error('Salvare lead în DB eșuată, trec pe stub', ['error' => $e->getMessage()]);
        }

        return $this->persistStub($data, $ipHash);
    }

    /** Potrivește orașul scris de client cu un oraș din admin (după slug sau nume), dacă există. */
    protected function matchCity(string $name): ?City
    {
        $name = trim($name);
        if ($name === '') {
            return null;
        }
        $slug = Str::slug($name);

        return City::query()->where('slug', $slug)->first()
            ?? City::query()->where('name', $name)->first()
            ?? City::query()->where('slug', 'like', $slug.'%')->first();
    }

    protected function persistStub(array $data, string $ipHash): string
    {
        $reference = 'IP-'.strtoupper(Str::random(6));

        $record = array_merge($data, [
            'reference' => $reference,
            'ip_hash' => $ipHash,
            'consent_at' => now()->toIso8601String(),
            'created_at' => now()->toIso8601String(),
        ]);

        try {
            Storage::disk('local')->append('leads-stub/leads.jsonl', json_encode($record, JSON_UNESCAPED_UNICODE));
        } catch (Throwable $e) {
            Log::error('Stub lead: scriere fișier eșuată', ['error' => $e->getMessage()]);
        }

        Log::warning('Lead salvat în stub (tabel leads indisponibil)', [
            'reference' => $reference,
            'category' => $data['category'],
        ]);

        return $reference;
    }
}
