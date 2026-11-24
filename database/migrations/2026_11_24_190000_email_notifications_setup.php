<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Emailuri HTML (24.11.2026): adresa de notificare editabilă în admin (implicit vornicugabi96@gmail.com),
 * texte scurte de introducere (detaliile cererii și butoanele sunt generate automat în email) și emailul de confirmare pentru client.
 * Nu suprascrie texte modificate deja din admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings')) {
            $smtp = (array) SiteSetting::getValue('smtp', []);
            if (blank($smtp['admin_notify_to'] ?? null) || ($smtp['admin_notify_to'] ?? '') === 'admin@inlocuireparbriz.ro') {
                $smtp['admin_notify_to'] = 'vornicugabi96@gmail.com';
                SiteSetting::setValue('smtp', $smtp);
            }
        }

        if (! Schema::hasTable('notification_templates')) {
            return;
        }

        $oldBodies = [
            'lead.admin_email' => "Cerere {reference}\nClient: {customer_name}\nTelefon: {phone}\nVehicul: {vehicle_brand} {vehicle_model} {vehicle_year}\nGeam: {glass_type}\nMesaj: {description}",
            'lead.provider_email' => "Bună {provider_name},\nȚi s-a alocat cererea {reference}.\nClient: {customer_name} / {customer_phone}\nVehicul: {vehicle_brand} {vehicle_model} {vehicle_year}\nGeam: {glass_type}\nAdresă: {address}\nIntră în portal pentru detalii.",
        ];
        $new = [
            'lead.admin_email' => ['Cerere nouă {reference} – {customer_name}, {vehicle_brand} {vehicle_model}', 'A sosit o cerere nouă pe site. Detaliile sunt mai jos — sună clientul sau deschide cererea în admin ca s-o aloci unui atelier partener.'],
            'lead.provider_email' => ['Cerere nouă alocată: {reference} – {vehicle_brand} {vehicle_model}', "Bună, {provider_name}!\n\nȚi-am alocat o cerere nouă. Mai jos găsești detaliile mașinii și ale clientului."],
            'lead.customer_email' => ['Am primit cererea ta ({reference}) – inlocuireparbriz.ro', "Îți mulțumim pentru cerere. Am primit detaliile și ne ocupăm de ea.\n\nMai jos ai un rezumat al datelor trimise. Dacă ai greșit ceva, nicio problemă — clarificăm când te contactăm."],
        ];

        foreach ($new as $key => [$subject, $body]) {
            $row = DB::table('notification_templates')->where('key', $key)->first();
            if (! $row) {
                DB::table('notification_templates')->insert([
                    'key' => $key, 'channel' => 'email', 'subject' => $subject, 'body' => $body, 'is_active' => true,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            } elseif (isset($oldBodies[$key]) && trim((string) $row->body) === $oldBodies[$key]) {
                DB::table('notification_templates')->where('key', $key)->update(['subject' => $subject, 'body' => $body, 'updated_at' => now()]);
            }
        }
    }

    public function down(): void
    {
        // Texte; nu se revine.
    }
};
