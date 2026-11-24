<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Titluri fără majuscule inutile: numele site-ului devine „inlocuireparbriz.ro”
 * (în locul „Înlocuire Parbriz” / „InlocuireParbriz”). Doar texte — nu atinge structura.
 */
return new class extends Migration
{
    public function up(): void
    {
        $old = [' | Înlocuire Parbriz', ' | InlocuireParbriz.ro', ' | InlocuireParbriz'];

        if (Schema::hasColumn('cities', 'seo_title')) {
            foreach (DB::table('cities')->whereNotNull('seo_title')->get(['id', 'seo_title']) as $c) {
                $new = str_replace($old, ' | inlocuireparbriz.ro', $c->seo_title);
                if ($new !== $c->seo_title) {
                    DB::table('cities')->where('id', $c->id)->update(['seo_title' => $new]);
                }
            }
        }

        if (Schema::hasTable('posts')) {
            DB::table('posts')->where('author', 'Echipa Înlocuire Parbriz')->update(['author' => 'Echipa inlocuireparbriz.ro']);
            foreach (DB::table('posts')->whereNotNull('seo_title')->get(['id', 'seo_title']) as $p) {
                DB::table('posts')->where('id', $p->id)->update(['seo_title' => str_replace($old, ' | inlocuireparbriz.ro', $p->seo_title)]);
            }
        }

        if (Schema::hasTable('site_settings')) {
            $company = (array) SiteSetting::getValue('company', []);
            if (in_array($company['brand'] ?? null, ['Înlocuire Parbriz', 'InlocuireParbriz', 'InlocuireParbriz.ro'], true)) {
                $company['brand'] = 'inlocuireparbriz.ro';
                SiteSetting::setValue('company', $company);
            }
            $brand = (array) SiteSetting::getValue('brand', []);
            if (in_array($brand['name'] ?? null, ['InlocuireParbriz', 'Înlocuire Parbriz'], true)) {
                $brand['name'] = 'inlocuireparbriz.ro';
                SiteSetting::setValue('brand', $brand);
            }
        }
    }

    public function down(): void
    {
        // Doar texte; nu se revine.
    }
};
