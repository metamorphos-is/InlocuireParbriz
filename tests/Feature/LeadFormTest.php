<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\NotificationLog;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadFormTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $over = []): array
    {
        return array_merge([
            'name' => 'Ion Popescu', 'phone' => '0722 123 456', 'email' => 'ion@example.com',
            'category' => 'inlocuire-parbriz-bucuresti', 'area_type' => 'bucuresti', 'sector' => 3,
            'description' => 'Parbriz fisurat pe partea șoferului', 'vehicle_brand' => 'Dacia',
            'vehicle_model' => 'Logan', 'vehicle_year' => 2019, 'glass_type' => 'parbriz', 'consent' => '1',
        ], $over);
    }

    public function test_bucharest_lead_is_saved_unchanged(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload())->assertRedirect('/cerere-oferta/multumim');

        $lead = Lead::query()->firstOrFail();
        $this->assertSame('noua', $lead->status);
        $this->assertSame('București, Sectorul 3', $lead->address_text);
        $this->assertSame('sector-3', $lead->sector->slug);
    }

    public function test_lead_from_another_city_is_accepted(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload(['area_type' => 'alt_oras', 'sector' => null, 'locality' => 'Cluj-Napoca']))
            ->assertRedirect('/cerere-oferta/multumim');

        $this->assertSame('Cluj-Napoca', Lead::query()->value('address_text'));
    }

    public function test_other_city_requires_locality(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload(['area_type' => 'alt_oras', 'sector' => null]))
            ->assertSessionHasErrors('locality');
        $this->assertSame(0, Lead::query()->count());
    }

    public function test_new_lead_triggers_admin_and_customer_notifications(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload());

        // SMTP/SMSO sunt dezactivate în seed → notificările sunt înregistrate ca „skipped”, nu pierdute.
        $this->assertTrue(NotificationLog::query()->where('template_key', 'lead.admin_email')->exists());
        $this->assertTrue(NotificationLog::query()->where('template_key', 'lead.customer_sms')->exists());
    }

    public function test_company_test_data_is_shown_but_not_in_schema(): void
    {
        $this->seed();
        $html = $this->get('/contact')->assertOk()->assertSee('0700 000 000')->getContent();
        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $this->assertStringNotContainsString('telephone', $m[1] ?? '');

        SiteSetting::setValue('company', ['phone' => '0744 555 666', 'legal_name' => 'Real SRL', 'is_test' => false]);
        $html = $this->get('/contact')->getContent();
        preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $this->assertStringContainsString('+40744555666', $m[1] ?? '');
        $this->assertStringContainsString('Real SRL', $m[1] ?? '');
    }
}
