<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\CitySector;
use App\Models\NotificationTemplate;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Contul de admin se creează o singură dată; parola NU e în cod.
        // Se ia din ADMIN_INITIAL_PASSWORD (.env) sau se generează aleator.
        // Re-rularea seeder-ului nu mai resetează parola unui admin existent.
        User::query()->firstOrCreate(
            ['email' => 'admin@inlocuireparbriz.ro'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('ADMIN_INITIAL_PASSWORD') ?: Str::random(32)),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
                'company_name' => 'InlocuireParbriz',
            ]
        );

        $city = City::query()->updateOrCreate(
            ['slug' => 'bucuresti'],
            [
                'name' => 'București',
                'county' => 'București',
                'is_active' => true,
                'region' => 'bucuresti-ilfov',
                'coverage' => 'active',
                'sort_order' => 1,
            ]
        );

        foreach (range(1, 6) as $n) {
            CitySector::query()->updateOrCreate(
                ['city_id' => $city->id, 'slug' => "sector-{$n}"],
                ['name' => "Sector {$n}", 'is_active' => true]
            );
        }

        $roots = [
            ['Înlocuire parbrize', 'inlocuire-parbrize', 'glass'],
            ['Reparații parbrize', 'reparatii-parbrize', 'repair'],
            ['Lunete și geamuri', 'lunete-geamuri', 'window'],
            ['Servicii mobile', 'servicii-mobile', 'van'],
            ['Calibrare ADAS', 'calibrare-adas', 'camera'],
            ['Servicii pentru firme', 'servicii-firme', 'fleet'],
        ];

        $subs = [
            'inlocuire-parbrize' => [
                'Înlocuire parbriz auto', 'Parbriz original', 'Parbriz aftermarket',
                'Autoutilitare', 'Camioane',
            ],
            'reparatii-parbrize' => [
                'Reparare ciobitură', 'Lovitură de piatră', 'Evaluare avarie',
            ],
            'lunete-geamuri' => [
                'Lunetă', 'Geam lateral', 'Geam portieră',
            ],
            'servicii-mobile' => [
                'La domiciliu', 'La sediul firmei', 'În parcare',
            ],
            'calibrare-adas' => [
                'Calibrare cameră frontală', 'Verificare senzori',
            ],
            'servicii-firme' => [
                'Flote auto', 'Autoutilitare firme',
            ],
        ];

        $sort = 0;
        foreach ($roots as [$name, $slug, $icon]) {
            $parent = Category::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'parent_id' => null,
                    'name' => $name,
                    'description' => "{$name} — București",
                    'icon' => $icon,
                    'sort_order' => $sort++,
                    'is_active' => true,
                ]
            );

            $childSort = 0;
            foreach ($subs[$slug] ?? [] as $childName) {
                Category::query()->updateOrCreate(
                    ['slug' => Str::slug($childName)],
                    [
                        'parent_id' => $parent->id,
                        'name' => $childName,
                        'description' => null,
                        'icon' => null,
                        'sort_order' => $childSort++,
                        'is_active' => true,
                    ]
                );
            }
        }

        $templates = [
            [
                'key' => 'lead.admin_email',
                'channel' => 'email',
                'subject' => 'Cerere nouă {reference} – {customer_name}, {vehicle_brand} {vehicle_model}',
                'body' => 'A sosit o cerere nouă pe site. Detaliile sunt mai jos — sună clientul sau deschide cererea în admin ca s-o aloci unui atelier partener.',
            ],
            [
                'key' => 'lead.customer_sms',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'inlocuireparbriz.ro: am primit solicitarea {reference}. Te contactăm în curând.',
            ],
            [
                'key' => 'lead.provider_sms',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'inlocuireparbriz.ro: cerere {reference} alocată. Detalii în portal.',
            ],
            [
                'key' => 'lead.provider_email',
                'channel' => 'email',
                'subject' => 'Cerere nouă alocată: {reference} – {vehicle_brand} {vehicle_model}',
                'body' => "Bună, {provider_name}!\n\nȚi-am alocat o cerere nouă. Mai jos găsești detaliile mașinii și ale clientului.",
            ],
            [
                'key' => 'lead.customer_email',
                'channel' => 'email',
                'subject' => 'Am primit cererea ta ({reference}) – inlocuireparbriz.ro',
                'body' => "Îți mulțumim pentru cerere. Am primit detaliile și ne ocupăm de ea.\n\nMai jos ai un rezumat al datelor trimise. Dacă ai greșit ceva, nicio problemă — clarificăm când te contactăm.",
            ],
        ];

        foreach ($templates as $tpl) {
            NotificationTemplate::query()->updateOrCreate(
                ['key' => $tpl['key']],
                array_merge($tpl, ['is_active' => true])
            );
        }

        SiteSetting::setValue('brand', [
            'name' => 'inlocuireparbriz.ro',
            'team' => 'Echipa inlocuireparbriz.ro',
            'tagline' => 'Înlocuire și reparații parbrize în București',
        ]);

        SiteSetting::setValue('seo', [
            'noindex' => true,
            'default_robots' => 'noindex,nofollow',
        ]);

        SiteSetting::setValue('smtp', [
            'enabled' => false,
            'host' => 'smtp.hostinger.com',
            'port' => 465,
            'username' => '',
            'password' => '',
            'encryption' => 'ssl',
            'from_address' => 'noreply@inlocuireparbriz.ro',
            'from_name' => 'inlocuireparbriz.ro',
            'admin_notify_to' => 'vornicugabi96@gmail.com',
        ]);

        SiteSetting::setValue('smso', [
            'enabled' => false,
            'api_key' => '',
            'sender' => '',
        ]);
    }
}
