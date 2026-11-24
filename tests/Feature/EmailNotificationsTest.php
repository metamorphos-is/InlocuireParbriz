<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\SiteSetting;
use App\Services\Notifications\LeadNotifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailNotificationsTest extends TestCase
{
    use RefreshDatabase;

    private function sentMessages(): array
    {
        return app('mail.manager')->mailer('array')->getSymfonyTransport()->messages()->all();
    }

    public function test_new_lead_sends_html_email_to_admin_and_customer_with_buttons(): void
    {
        $this->seed();
        config(['mail.default' => 'array']);
        SiteSetting::setValue('smtp', array_merge((array) SiteSetting::getValue('smtp', []), ['enabled' => true, 'host' => '', 'from_address' => 'noreply@inlocuireparbriz.ro']));

        $lead = Lead::query()->create([
            'customer_name' => 'Maria Ionescu', 'phone' => '0744111222', 'email' => 'maria@example.com',
            'vehicle_brand' => 'Skoda', 'vehicle_model' => 'Octavia', 'vehicle_year' => '2020',
            'glass_type' => 'parbriz', 'glass_features' => ['senzor_ploaie'], 'description' => 'Fisură lungă', 'status' => 'new',
        ]);
        $n = app(LeadNotifier::class);
        $n->notifyAdminNewLead($lead);
        $n->notifyCustomerReceived($lead);

        $msgs = $this->sentMessages();
        $this->assertCount(2, $msgs);

        $admin = $msgs[0]->getOriginalMessage();
        $this->assertSame('vornicugabi96@gmail.com', $admin->getTo()[0]->getAddress());
        $html = $admin->getHtmlBody();
        $this->assertStringContainsString('Deschide cererea în admin', $html);
        $this->assertStringContainsString('/admin/leads/'.$lead->id.'/edit', $html);
        $this->assertStringContainsString('tel:+40744111222', $html);
        $this->assertStringContainsString('https://wa.me/40744111222', $html);
        $this->assertStringContainsString('Senzor de ploaie', $html);
        $this->assertNotEmpty($admin->getTextBody());

        $customer = $msgs[1]->getOriginalMessage();
        $this->assertSame('maria@example.com', $customer->getTo()[0]->getAddress());
        $this->assertStringContainsString('Mulțumim, Maria!', $customer->getHtmlBody());
        $this->assertStringNotContainsString('/admin/', $customer->getHtmlBody());
    }

    public function test_admin_recipients_are_editable_with_default(): void
    {
        $this->seed();
        SiteSetting::setValue('smtp', ['admin_notify_to' => '']);
        $this->assertSame(['vornicugabi96@gmail.com'], LeadNotifier::adminRecipients());

        SiteSetting::setValue('smtp', ['admin_notify_to' => 'a@x.ro, b@y.ro; invalid']);
        $this->assertSame(['a@x.ro', 'b@y.ro'], LeadNotifier::adminRecipients());
    }

    public function test_all_channels_on_assignment_and_status_changes(): void
    {
        $this->seed();
        config(['mail.default' => 'array']);
        SiteSetting::setValue('smtp', array_merge((array) SiteSetting::getValue('smtp', []), ['enabled' => true, 'host' => '']));
        SiteSetting::setValue('smso', ['enabled' => false, 'admin_phone' => '0722 111 222']);

        $providerUser = \App\Models\User::factory()->create(['role' => \App\Models\User::ROLE_PROVIDER, 'is_active' => true, 'email' => 'atelier@example.com']);
        $provider = \App\Models\Provider::query()->create(['user_id' => $providerUser->id, 'company_name' => 'Atelier Test', 'email' => 'atelier@example.com', 'phone' => '0733000000', 'status' => 'active']);
        $lead = Lead::query()->create(['customer_name' => 'Ana', 'phone' => '0744111222', 'email' => 'ana@example.com', 'status' => 'noua']);

        app(\App\Services\LeadWorkflow::class)->assign($lead, $provider->id, null);
        $to = collect($this->sentMessages())->map(fn ($m) => $m->getOriginalMessage()->getTo()[0]->getAddress())->all();
        $this->assertContains('atelier@example.com', $to);
        $this->assertContains('ana@example.com', $to);

        // SMS-urile sunt jurnalizate (SMSO dezactivat aici → „skipped”, dar încercate)
        $smsKeys = \App\Models\NotificationLog::query()->where('channel', 'sms')->pluck('template_key')->all();
        $this->assertContains('lead.provider_sms', $smsKeys);
        $this->assertContains('lead.customer_assigned_sms', $smsKeys);

        // Atelierul schimbă statusul → client + admin
        app(\App\Services\LeadWorkflow::class)->changeStatus($lead->fresh(), 'programata', $providerUser->id);
        $keys = \App\Models\NotificationLog::query()->pluck('template_key')->all();
        $this->assertContains('lead.customer_status_sms', $keys);
        $this->assertContains('lead.customer_status_email', $keys);
        $this->assertContains('lead.admin_status_email', $keys);

        // Atelierul refuză → SMS admin
        app(\App\Services\LeadWorkflow::class)->changeStatus($lead->fresh(), 'refuzata', $providerUser->id);
        $this->assertTrue(\App\Models\NotificationLog::query()->where('template_key', 'lead.admin_status_sms')->where('recipient', '0722 111 222')->exists());

        // Cerere nouă → SMS admin
        app(LeadNotifier::class)->notifyAdminNewLead($lead->fresh());
        $this->assertTrue(\App\Models\NotificationLog::query()->where('template_key', 'lead.admin_sms')->exists());
    }
}
