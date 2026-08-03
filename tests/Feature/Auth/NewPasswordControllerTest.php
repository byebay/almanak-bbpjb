<?php

namespace Tests\Feature\Auth;

use App\Http\Controllers\Auth\NewPasswordController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class NewPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_redirects_to_success_page_and_logs_in_user(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('old-password'),
        ]);

        Auth::logout();

        Password::shouldReceive('reset')
            ->once()
            ->andReturnUsing(function ($credentials, $callback) use ($user) {
                $callback($user);

                return Password::PASSWORD_RESET;
            });

        $request = new Request([
            'token' => 'token-123',
            'email' => 'user@example.com',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $controller = new NewPasswordController();
        $response = $controller->store($request);

        $this->assertEquals(route('password.reset.success'), $response->getTargetUrl());
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::id() === $user->id);
    }
}
