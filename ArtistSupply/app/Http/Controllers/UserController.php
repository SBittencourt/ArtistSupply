<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home() {
        $user = auth()->user(); 
        return view('home', compact('user')); 
    }
}
