<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            'user' => 'user1',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'todo1'
                ],
                [
                    'id' => '2',
                    'todo' => 'todo2'
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText("todo1")
            ->assertSeeText("2")
            ->assertSeeText("todo2");
    }

    public function testAddTodoFailed()
    {
        $this->withSession(['user' => 'user1'])
            ->post('/todolist', [])
            ->assertSeeText('Todolist is Required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession(['user' => 'user1'])
            ->post('/todolist', [
                'todo' => 'todo1'
            ])->assertRedirect('/todolist');
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            'user' => 'user1',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'todo1'
                ],
                [
                    'id' => '2',
                    'todo' => 'todo2'
                ]
            ]
        ])->post('/todolist/1/delete')
            ->assertRedirect('/todolist');
    }
}
