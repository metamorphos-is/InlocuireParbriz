<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class AntiSpamTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $over = [], int $age = 30): array
    {
        $ft = Crypt::encryptString((string) (time() - $age));

        return array_merge([
            '_ft' => $ft, '_js' => 'ok-'.substr(hash('sha256', $ft), 0, 12),
            'name' => 'Ion Popescu', 'phone' => '0722 123 456', 'email' => 'ion@example.com',
            'category' => 'inlocuire-parbriz-bucuresti', 'area_type' => 'bucuresti', 'sector' => 3,
            'description' => 'Parbriz fisurat pe partea șoferului', 'consent' => '1',
        ], $over);
    }

    public function test_real_person_passes_and_phone_is_normalized(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload(['phone' => '+40 722 123 456']))->assertRedirect('/cerere-oferta/multumim');
        $this->assertSame('0722123456', Lead::query()->firstOrFail()->phone);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('botCases')]
    public function test_bots_are_silently_dropped(array $over, int $age = 30): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload($over, $age))->assertRedirect('/cerere-oferta/multumim');
        $this->assertSame(0, Lead::query()->count());
    }

    public static function botCases(): array
    {
        return [
            'honeypot' => [['website' => 'http://spam.ru']],
            'honeypot 2' => [['fax' => '123']],
            'prea rapid' => [[], 1],
            'fără token' => [['_ft' => '']],
            'fără JS' => [['_js' => '']],
            'link în mesaj' => [['description' => 'Best prices visit www.cheap-stuff.com now']],
            'chirilic' => [['description' => 'Привет, лучшие цены на рекламу']],
        ];
    }

    public function test_fake_phone_and_name_get_a_visible_error(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload(['phone' => '0700 000 000']))->assertSessionHasErrors('phone');
        $this->post('/cerere-oferta', $this->payload(['phone' => '0712345678']))->assertSessionHasErrors('phone');
        $this->post('/cerere-oferta', $this->payload(['phone' => '+44 7700 900123']))->assertSessionHasErrors('phone');
        $this->post('/cerere-oferta', $this->payload(['name' => 'Bot123']))->assertSessionHasErrors('name');
        $this->assertSame(0, Lead::query()->count());
    }

    public function test_duplicate_within_30_minutes_is_not_saved_twice(): void
    {
        $this->seed();
        $this->post('/cerere-oferta', $this->payload());
        $this->post('/cerere-oferta', $this->payload());
        $this->assertSame(1, Lead::query()->count());
        $this->assertNotEmpty(SpamGuard::stats());
    }

    public function test_form_contains_tokens(): void
    {
        $this->seed();
        $this->get('/cerere-oferta')->assertOk()->assertSee('name="_ft"', false)->assertSee('data-js-token="ok-', false);
    }
}
