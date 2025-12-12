<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Главная страница',
            'message' => 'Добро пожаловать!'
        ];
        
        $this->view('home/index', $data);
    }
}