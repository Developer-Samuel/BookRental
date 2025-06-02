<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\RateLimiter;

use App\Models\User\User;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    protected string $loginRoute = '/login';

    #[Test]
    public function userCanLoginSuccessfully(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->postJson($this->loginRoute, [
            'email'    => $user->email,
            'password' => '12345678',
        ]);

        $response
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', 'Successfully logged in.')
                     ->etc()
            );

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function userCannotLoginWithInvalidCredentials(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->postJson($this->loginRoute, [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response
            ->assertUnauthorized()
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', 'Invalid login details.')
                     ->etc()
            );

        $this->assertGuest();
    }

    #[Test]
    public function userHasManyFailedLoginAttempts(): void
    {
        $user = User::create([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $this->postJson($this->loginRoute, [
                'email'    => $user->email,
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->postJson($this->loginRoute, [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(429)
            ->assertJson(fn (AssertableJson $json) =>
                $json->where('message', fn ($message) =>
                    str_contains($message, 'Too many login attempts')
                )->etc()
            );
    }

    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('auth:login');
    }
}
