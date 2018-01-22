<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{

    public function show($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $user = User::where('id', $args['id'])->first();
        $avatar = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/avatars/' . $user->id . '/avatar.jpg')) {
            $avatar = '/assets/uploads/avatars/' . $user->id . '/avatar.jpg';
        }

        return $this->view->render($response, 'dashboard/users/view.twig', compact('user', 'avatar'));
    }

    public function edit($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $user = User::where('id', $args['id'])->first();
        $featured = null;

        if ($this->auth->user()->id != $user->id) {
            if ($this->auth->user()->role != 'admin') {
                $this->flash->addMessage('error', 'You do not have the proper permissions for this operation.');
                return $response->withRedirect($this->router->pathFor('users.index'));
            }
        }

        if (file_exists(__DIR__ . '/../../../assets/uploads/avatars/' . $user->id . '/avatar.jpg')) {
            $featured = '/../../../assets/uploads/avatars/' . $user->id . '/avatar.jpg';
        }

        return $this->view->render($response, 'dashboard/users/edit.twig', compact('user', 'featured'));
    }

    public function update($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();

        if (isset($params['password'])) {
            $password = $params['password'];
        }

        $files = $_FILES;
        $image = $files['featured'];
        $user = User::where('id', $args['id'])->first();
        $id = $user->id;

        $user->name = $params['name'];
        if (isset($params['password'])) {
            $user->password = password_hash($params['password'], PASSWORD_DEFAULT);
        }
        if (isset($params['email'])) {
            $user->email = $params['email'];
        }

        $user->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/avatars/' . $user->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/avatars/' . $user->id);
            $user->avatar = $user->id;
            $user->save();
        }

        move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/avatars/' . $user->id . '/avatar.jpg');

        $this->flash->addMessage('info', 'User Edited!');

        return $response->withRedirect($this->router->pathFor('users.view', ['id' => $user->id]));
    }
}

