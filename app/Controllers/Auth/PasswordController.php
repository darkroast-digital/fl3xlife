<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
    public function getForgot($request, $response, $args)
    {
        if ($this->auth->check() == true) {
            return $response->withRedirect($this->router->pathFor('dash'));
        }

        return $this->view->render($response, 'auth/forgot.twig');
    }

    public function postForgot($request, $response, $args)
    {
        $user = User::where('email', $request->getParam('email'))->first();

        if ($user == NULL) {
            $this->flash->addMessage('error', 'That is not an existing user email address.');

            return $response->withRedirect($this->router->pathFor('forgot')); 
        }

        $hash = hash('sha256', $user->email . time());
        $user->reset_token = $hash;
        $user->save();

        $this->mail->from('kim@darkroast.co', 'Kim Morin')
            ->to([
                [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ])
            ->subject('Hey, ' . $user->name . '! A password reset was requested on your account.')
            ->send('mail/mail.twig', compact('user'));

        $this->flash->addMessage('info', 'Check your email for your reset link.');

        return $response->withRedirect($this->router->pathFor('forgot')); 
    }

    public function getReset($request, $response, $args)
    {
        $token = $args['token'];

        return $this->view->render($response, 'auth/reset.twig', compact('token'));
    }

    public function postReset($request, $response, $args)
    {
        $user = User::where('reset_token', $args['token'])->first();
        $password = $request->getParam('password');

        $validation = $this->validator->validate($request, [
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('forgot'));
        }

        $user->password = password_hash($password, PASSWORD_DEFAULT);
        $user->reset_token = NULL;
        $user->save();

        $this->flash->addMessage('info', 'Your password was changed successfully.');
        return $response->withRedirect($this->router->pathFor('login'));
    }
}

