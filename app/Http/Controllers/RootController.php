<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootController extends Controller
{
    public function showRegistrationForm()
    {
      return view('auth/register');
    }
    public function showLoginForm()
    {
      return view('auth/login');
    }
}
