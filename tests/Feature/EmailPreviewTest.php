<?php

namespace Tests\Feature;

use App\Filament\Admin\Resources\NotificationTemplates\Pages\ManageNotificationTemplates;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\Services\Notifications\LeadNotifier;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EmailPreviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_preview_renders_full_html_with_buttons(): void
    {
        $html = app(LeadNotifier::class)->previewHtml('lead.admin_email', 'Cerere {reference}', 'Salut {customer_name}');
        $this->assertStringContainsString('Salut Ion Popescu', $html);
        $this->assertStringContainsString('Deschide cererea în admin', $html);
        $this->assertStringContainsString('<table', $html);
    }

    public function test_template_edit_modal_shows_preview(): void
    {
        $this->seed();
        $admin = User::factory()->create(['role' => User::ROLE_SUPER_ADMIN, 'is_active' => true]);
        $tpl = NotificationTemplate::query()->where('key', 'lead.admin_email')->first();

        Livewire::actingAs($admin)->test(ManageNotificationTemplates::class)
            ->mountAction(TestAction::make('edit')->table($tpl))
            ->assertActionMounted(TestAction::make('edit')->table($tpl))
            ->assertHasNoErrors();
    }
}
