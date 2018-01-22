<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\User;

class DashController extends Controller
{
    public function index($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        } else {
            $users = User::get()->all();

            return $this->view->render($response, 'dashboard/index.twig', compact('users'));
        }
    }
}

