<?php

namespace Tests\Feature;

use App\Services\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM users');
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSucces()
    {
        $this->seed([UserSeeder::class]);
        $login = $this->userService->login('user1@example.com', 'password');
        $this->assertTrue($login);
    }

    public function testLoginNotFound()
    {
        $this->assertFalse($this->userService->login('notFound', 'pasword'));
    }

    public function testLoginWrongPassword()
    {
        $this->assertFalse($this->userService->login('user1', 'wrongPassword'));
    }
}
