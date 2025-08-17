<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'user1',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'user1');
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
}
