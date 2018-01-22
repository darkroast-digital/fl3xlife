<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\Testimony;

class TestimoniesController extends Controller
{
    public function index($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $testimonies = Testimony::get()->all();

        return $this->view->render($response, 'dashboard/testimonies/index.twig', compact('testimonies'));
    }

    public function show($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $testimony = Testimony::where('id', $args['slug'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id . '/featured.png')) {
            $featured = '/assets/uploads/testimonies/' . $testimony->id . '/featured.png';
        }

        return $this->view->render($response, 'dashboard/testimonies/view.twig', compact('testimony', 'featured'));
    }

    public function create($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        if ($this->auth->user()->role != 'admin') {
            $this->flash->addMessage('error', 'You do not have the proper permissions for this operation.');
            return $response->withRedirect($this->router->pathFor('testimonies.index'));
        }

        return $this->view->render($response, 'dashboard/testimonies/create.twig');
    }

    public function store($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();
        $files = $_FILES;
        $featured = $files['featured'];

        $testimony = Testimony::create([
            'name' => $params['name'],
            'quote' => $params['quote'],
            'description' => $params['description'],
            'role' => $params['role'],
        ]);

        if (!file_exists(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id);
            $testimony->featured = $testimony->id;
            $testimony->save();
        }

        if ($featured['tmp_name'] != "") {
            move_uploaded_file($featured['tmp_name'], __DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id . '/featured.png');
        }

        $testimony->save();

        $this->flash->addMessage('info', 'Testimony Added!');
        return $response->withRedirect($this->router->pathFor('testimonies.index'));
    }

    public function edit($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $testimony = Testimony::where('id', $args['slug'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id . '/featured.png')) {
            $featured = '/assets/uploads/testimonies/' . $testimony->id . '/featured.png';
        }

        return $this->view->render($response, 'dashboard/testimonies/edit.twig', compact('testimony', 'featured'));
    }

    public function update($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();
        $files = $_FILES;
        $featured = $files['featured'];
        $testimony = Testimony::where('id', $args['slug'])->first();

        $testimony->name = $params['name'];
        $testimony->quote = $params['quote'];
        $testimony->description = $params['description'];
        $testimony->role = $params['role'];

        $testimony->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id);
            $testimony->featured = $testimony->id;
            $testimony->save();
        }

        move_uploaded_file($featured['tmp_name'], __DIR__ . '/../../../assets/uploads/testimonies/' . $testimony->id . '/featured.png');

        $this->flash->addMessage('info', 'Testimony Edited!');

        return $response->withRedirect($this->router->pathFor('testimonies.view', ['slug' => $testimony->id]));
    }

    public function delete($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        if ($this->auth->user()->role != 'admin') {
            $this->flash->addMessage('error', 'You do not have the proper permissions for this operation.');
            return $response->withRedirect($this->router->pathFor('testimonies.index'));
        }

        $testimony = Testimony::where('id' , $args['slug'])->first();
        $testimony->delete();

        $this->flash->addMessage('info', 'Testimony Deleted!');
        return $response->withRedirect($this->router->pathFor('testimonies.index'));
    }
}

