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
}
