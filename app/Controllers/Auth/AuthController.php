<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin($request, $response, $args)
    {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function postLogin($request, $response, $args)
    {
        $user = User::where('email', $request->getParam('email'))->first();

        if (!$user) {
            $this->flash->addMessage('error', 'Sorry, that is not a recognized user.');
            return $response->withRedirect($this->router->pathFor('login'));
        }

        if (password_verify($request->getParam('password'), $user->password)) {
            $_SESSION['user'] = $user;
            return $response->withRedirect($this->router->pathFor('dash'));
        } else {
            $this->flash->addMessage('error', 'Incorrect password. Please try again.');
            return $response->withRedirect($this->router->pathFor('login'));
        }
    }

    public function getLogout($request, $response, $args)
    {
        unset($_SESSION['user']);

        $this->flash->addMessage('info', 'You have successfully logged-out!');

        return $response->withRedirect($this->router->pathFor('login'));
    }
}

