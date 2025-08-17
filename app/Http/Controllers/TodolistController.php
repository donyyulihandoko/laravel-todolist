<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    private TodolistService $todolistService;

    public function __construct(TodolistService $todolistService)
    {
        $this->todolistService = $todolistService;
    }

    public function todolist()
    {
        $todolist = $this->todolistService->getTodo();
        return response()
            ->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $todolist
            ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        // validasi error
        if (empty($todo)) {
            return response()
                ->view('todolist.todolist', [
                    'title' => 'Todolist',
                    'error' => 'Todolist is Required'
                ]);
        }

        // dependency injection
        $this->todolistService->saveTodo(uniqid(), $todo);
        return redirect()->action([TodolistController::class, 'todolist']);
    }

    public function removeTodo(string $todoId)
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todolist']);
    }
}
