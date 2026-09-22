<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OwnerRegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_registration_creates_only_account_and_redirects_to_business_setup(): void
    {
        Livewire::test('pages::auth.shop_owner_auth.register')
            ->set('name', 'Maria Dela Cruz')
            ->set('email', 'owner@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->call('register');

        $user = User::query()->where('email', 'owner@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('owner'));
        $this->assertNull($user->tenant);
        $this->assertDatabaseMissing('tenants', ['user_id' => $user->id]);
    }
}
