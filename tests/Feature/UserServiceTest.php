<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSucces()
    {
        $this->assertTrue($this->userService->login('user1', 'rahasia'));
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
