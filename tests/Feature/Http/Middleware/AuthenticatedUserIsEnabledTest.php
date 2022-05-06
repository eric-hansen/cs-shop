<?php

namespace Tests\Feature\Http\Middleware;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticatedUserIsEnabledTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_able_to_login_with_enabled_account()
    {
        $user = User::factory(1)->create()->first();

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(200);
    }

    public function test_error_when_account_disabled()
    {
        $user = User::factory(1)->disabled()->create()->first();

        $response = $this->actingAs($user)->get('/products');

        $response->assertStatus(403);
    }
}
