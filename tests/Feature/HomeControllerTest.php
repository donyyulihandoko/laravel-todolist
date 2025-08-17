<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomeWithSession()
    {
        $this->withSession([
            'user' => 'user1'
        ])->get('/')
            ->assertRedirect('/todolist');
    }

    public function testHomeWithoutSession()
    {
        $this->get('/')
            ->assertRedirect('/login');
    }
}
