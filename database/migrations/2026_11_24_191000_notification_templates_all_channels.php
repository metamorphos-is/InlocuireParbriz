<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Notificări pe toate canalele (24.11.2026): șabloane noi pentru SMS admin, atribuire către client,
 * schimbări de status (client, admin, atelier). Doar adaugă șabloanele lipsă; nu modifică ce există.
 * SMS-urile sunt fără diacritice, ca să încapă într-un singur mesaj (160 de caractere).
 */
return new class extends Migration
{
    public const TEMPLATES = [
        ['lead.admin_sms', 'sms', null, 'Cerere noua {reference}: {customer_name}, {phone}, {vehicle_brand} {vehicle_model}, {city}. Detalii in admin.'],
        ['lead.customer_assigned_sms', 'sms', null, 'inlocuireparbriz.ro: cererea {reference} a fost preluata de un atelier partener din zona ta. Te contacteaza in curand cu oferta.'],
        ['lead.customer_assigned_email', 'email', 'Am găsit un atelier partener pentru cererea {reference}', "Vești bune: cererea ta a fost preluată de un atelier partener verificat din zona ta."],
        ['lead.customer_status_sms', 'sms', null, 'inlocuireparbriz.ro: cererea {reference} - {status}. Multumim!'],
        ['lead.customer_status_email', 'email', 'Cererea {reference}: {status}', "Avem o noutate despre cererea ta."],
        ['lead.admin_status_email', 'email', 'Cererea {reference}: {status_old} → {status} ({provider_name})', "Atelierul {provider_name} a actualizat statusul cererii {reference}."],
        ['lead.admin_status_sms', 'sms', null, 'Atelierul {provider_name} a refuzat cererea {reference} ({vehicle_brand} {vehicle_model}, {city}). Atribuie-o altui atelier.'],
        ['lead.provider_status_sms', 'sms', null, 'inlocuireparbriz.ro: cererea {reference} a fost anulata. Nu mai e nevoie sa contactezi clientul.'],
        ['lead.provider_status_email', 'email', 'Cererea {reference} a fost anulată', "Bună, {provider_name}!\n\nCererea de mai jos a fost anulată."],
    ];

    public function up(): void
    {
        if (! Schema::hasTable('notification_templates')) {
            return;
        }
        foreach (self::TEMPLATES as [$key, $channel, $subject, $body]) {
            if (DB::table('notification_templates')->where('key', $key)->exists()) {
                continue;
            }
            DB::table('notification_templates')->insert([
                'key' => $key, 'channel' => $channel, 'subject' => $subject, 'body' => $body, 'is_active' => true,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Texte; nu se șterg.
    }
};
