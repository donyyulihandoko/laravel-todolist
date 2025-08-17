<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodolistServiceTest extends TestCase
{
    private TodolistService $todolistService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    public function testTrue()
    {
        $this->assertNotNull($this->todolistService);
    }

    public function testSaveTodolist()
    {
        $this->todolistService->saveTodo('1', 'coba');

        $todolist = Session::get('todolist');

        foreach ($todolist as $row) {
            $this->assertEquals('1', $row['id']);
            $this->assertEquals('coba', $row['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        $this->assertEquals([], $this->todolistService->getTodo());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'todo1'
            ],
            [
                'id' => '2',
                'todo' => 'todo2'
            ]
        ];

        $this->todolistService->saveTodo('1', 'todo1');
        $this->todolistService->saveTodo('2', 'todo2');

        $this->assertEquals($expected, $this->todolistService->getTodo());
    }

    public function testRemoveTodo()
    {
        $this->todolistService->saveTodo('1', 'todo1');
        $this->todolistService->saveTodo('2', 'todo2');

        $this->assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('3');
        $this->assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('2');
        $this->assertEquals(1, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo('1');
        $this->assertEquals(0, sizeof($this->todolistService->getTodo()));
    }
}
