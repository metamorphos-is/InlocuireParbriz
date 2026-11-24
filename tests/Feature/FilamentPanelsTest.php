<?php

namespace Tests\Feature;

use App\Filament\Admin\Pages\SiteSettings;
use App\Filament\Admin\Resources\Leads\Pages\EditLead;
use App\Filament\Admin\Resources\Leads\Pages\ListLeads as AdminListLeads;
use App\Filament\Portal\Resources\Leads\Pages\ListLeads as PortalListLeads;
use App\Filament\Portal\Resources\Leads\Pages\ViewLead;
use App\Models\Lead;
use App\Models\Provider;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Filament\Facades\Filament;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentPanelsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
    }

    /** @return array{0:User,1:Provider} */
    private function providerUser(string $company): array
    {
        $user = User::factory()->create(['role' => User::ROLE_PROVIDER, 'is_active' => true]);
        $provider = Provider::query()->create([
            'user_id' => $user->id,
            'company_name' => $company,
            'email' => $user->email,
            'status' => 'active',
        ]);

        return [$user, $provider];
    }

    private function lead(array $attrs = []): Lead
    {
        return Lead::query()->create($attrs + [
            'customer_name' => 'Client Test',
            'phone' => '0700000000',
            'status' => 'noua',
        ]);
    }

    public function test_panel_access_is_role_based(): void
    {
        [$providerUser] = $this->providerUser('P1');

        $this->actingAs($this->admin())->get('/admin')->assertOk();
        $this->actingAs($this->admin())->get('/portal')->assertForbidden();

        $this->actingAs($providerUser)->get('/admin')->assertForbidden();
        $this->actingAs($providerUser)->get('/portal')->assertOk();
    }

    public function test_inactive_user_cannot_enter_panels(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_all_admin_pages_render(): void
    {
        $this->actingAs($this->admin());
        $lead = $this->lead();

        foreach ([
            '/admin/leads', '/admin/leads/create', "/admin/leads/{$lead->id}/edit",
            '/admin/providers', '/admin/users', '/admin/categories', '/admin/cities',
            '/admin/sectors', '/admin/seo-pages', '/admin/notification-templates', '/admin/setari-site',
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_provider_only_sees_assigned_leads(): void
    {
        [$userA, $providerA] = $this->providerUser('A');
        [, $providerB] = $this->providerUser('B');

        $mine = $this->lead(['assigned_provider_id' => $providerA->id, 'status' => 'atribuita']);
        $theirs = $this->lead(['assigned_provider_id' => $providerB->id, 'status' => 'atribuita']);
        $unassigned = $this->lead();

        $this->actingAs($userA);
        Filament::setCurrentPanel('portal');

        Livewire::test(PortalListLeads::class)
            ->assertCanSeeTableRecords([$mine])
            ->assertCanNotSeeTableRecords([$theirs, $unassigned]);

        $this->get("/portal/leads/{$theirs->id}")->assertNotFound();
        $this->get("/portal/leads/{$mine->id}")->assertOk();
    }

    public function test_provider_can_update_status_only_on_own_lead(): void
    {
        [$userA, $providerA] = $this->providerUser('A');
        $mine = $this->lead(['assigned_provider_id' => $providerA->id, 'status' => 'atribuita', 'agreed_amount' => 100]);

        $this->actingAs($userA);
        Filament::setCurrentPanel('portal');

        Livewire::test(ViewLead::class, ['record' => $mine->getKey()])
            ->callAction('update_status', ['status' => 'finalizata', 'note' => 'Gata'])
            ->assertHasNoActionErrors();

        $mine->refresh();
        $this->assertSame('finalizata', $mine->status);
        $this->assertSame('100.00', (string) $mine->agreed_amount);
        $this->assertDatabaseHas('lead_notes', ['lead_id' => $mine->id, 'body' => 'Gata']);
        $this->assertDatabaseHas('lead_events', ['lead_id' => $mine->id, 'type' => 'status_changed']);
    }

    public function test_admin_sees_all_and_can_assign(): void
    {
        $admin = $this->admin();
        [, $provider] = $this->providerUser('A');
        $lead = $this->lead();

        $this->actingAs($admin);
        Filament::setCurrentPanel('admin');

        Livewire::test(AdminListLeads::class)
            ->assertCanSeeTableRecords([$lead])
            ->callTableAction('assign', $lead, ['provider_id' => $provider->id])
            ->assertHasNoTableActionErrors();

        $lead->refresh();
        $this->assertSame($provider->id, $lead->assigned_provider_id);
        $this->assertSame('atribuita', $lead->status);
        $this->assertDatabaseHas('lead_assignments', ['lead_id' => $lead->id, 'provider_id' => $provider->id]);
    }

    public function test_admin_edit_lead_saves_amount(): void
    {
        $this->actingAs($this->admin());
        Filament::setCurrentPanel('admin');
        $lead = $this->lead();

        Livewire::test(EditLead::class, ['record' => $lead->getKey()])
            ->fillForm(['agreed_amount' => 250.5, 'status' => 'in_analiza'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('250.50', (string) $lead->fresh()->agreed_amount);
    }

    public function test_site_settings_mask_and_encrypt_secrets(): void
    {
        $this->actingAs($this->admin());
        Filament::setCurrentPanel('admin');

        Livewire::test(SiteSettings::class)
            ->fillForm([
                'smtp.host' => 'smtp.example.test',
                'smtp.password' => 'dummy-pass',
                'smso.api_key' => 'dummy-key',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $smtp = SiteSetting::getValue('smtp');
        $this->assertSame('smtp.example.test', $smtp['host']);
        $this->assertStringStartsWith('enc:', $smtp['password']);
        $this->assertStringNotContainsString('dummy-pass', $smtp['password']);

        // A doua salvare cu parola goală păstrează valoarea existentă.
        $stored = $smtp['password'];
        Livewire::test(SiteSettings::class)->call('save')->assertHasNoFormErrors();
        $this->assertSame($stored, SiteSetting::getValue('smtp')['password']);
    }
}
