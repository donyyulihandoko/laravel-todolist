<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->exists('user')) {
            return redirect('/todolist');
        } else {
            return redirect('/login');
        }
    }
}
