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

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'user1'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'user1',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'user1');
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
