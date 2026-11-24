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
                'subject' => 'Cerere nouă {reference} — InlocuireParbriz',
                'body' => "Cerere {reference}\nClient: {customer_name}\nTelefon: {phone}\nVehicul: {vehicle_brand} {vehicle_model} {vehicle_year}\nGeam: {glass_type}\nMesaj: {description}",
            ],
            [
                'key' => 'lead.customer_sms',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'InlocuireParbriz: am primit solicitarea {reference}. Te contactăm în curând.',
            ],
            [
                'key' => 'lead.provider_sms',
                'channel' => 'sms',
                'subject' => null,
                'body' => 'InlocuireParbriz: cerere {reference} alocată. Detalii în portal.',
            ],
            [
                'key' => 'lead.provider_email',
                'channel' => 'email',
                'subject' => 'Cerere alocată {reference}',
                'body' => "Bună {provider_name},\nȚi s-a alocat cererea {reference}.\nClient: {customer_name} / {customer_phone}\nVehicul: {vehicle_brand} {vehicle_model} {vehicle_year}\nGeam: {glass_type}\nAdresă: {address}\nIntră în portal pentru detalii.",
            ],
        ];

        foreach ($templates as $tpl) {
            NotificationTemplate::query()->updateOrCreate(
                ['key' => $tpl['key']],
                array_merge($tpl, ['is_active' => true])
            );
        }

        SiteSetting::setValue('brand', [
            'name' => 'InlocuireParbriz',
            'team' => 'Înlocuire Parbriz',
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
            'from_name' => 'InlocuireParbriz',
            'admin_notify_to' => 'admin@inlocuireparbriz.ro',
        ]);

        SiteSetting::setValue('smso', [
            'enabled' => false,
            'api_key' => '',
            'sender' => '',
        ]);
    }
}
