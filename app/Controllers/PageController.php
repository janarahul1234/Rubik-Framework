<?php

namespace App\Controllers;

use App\core\Controller;

class PageController extends Controller
{
    public function index(): string
    {
        return view('welcome');
    }
}