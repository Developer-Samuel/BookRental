<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Session\NullSessionHandler;
use Illuminate\Session\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\Auth\AuthService;

use App\Models\User\User;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function canLoginSuccessful(): void
    {
        $password = '12345678';

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->password = Hash::make($password);
        $user->save();

        $service = $this->app->make(AuthService::class);

        $service->login($user->email, $password);

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }

    #[Test]
    public function canLogoutInvalidatesSessionAndLogsOut(): void
    {
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('12345678');
        $user->save();

        $this->actingAs($user);

        $service = new AuthService();

        $service->logout();

        $this->assertFalse(Auth::check());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $handler = new NullSessionHandler();
        $session = new Store('test_session', $handler);
        $request = Request::create('/', 'GET');
        $request->setLaravelSession($session);

        $this->app->instance('request', $request);
    }
}
