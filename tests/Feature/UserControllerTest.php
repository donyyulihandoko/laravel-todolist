<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;


class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("delete from users");
    }

    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'user1'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/login', [
            'user' => 'user1@example.com',
            'password' => 'password'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'user1@example.com');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'user1'
        ])->post('/login', [
            'user' => 'user1',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText('User or Password is Required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or Password is Wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'user1'
        ])->post('/logout')
            ->assertRedirect('/');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
