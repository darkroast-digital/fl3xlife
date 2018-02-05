<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\Instructor;

class InstructorsController extends Controller
{
    public function index($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $instructors = Instructor::get()->all();

        return $this->view->render($response, 'dashboard/instructors/index.twig', compact('instructors'));
    }

    public function show($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $instructor = Instructor::where('id', $args['id'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id . '/featured.jpg')) {
            $featured = '/assets/uploads/instructors/' . $instructor->id . '/featured.jpg';
        }

        $instructor->bio = $this->markdown->text($instructor->bio);

        return $this->view->render($response, 'dashboard/instructors/view.twig', compact('instructor', 'featured'));
    }

    public function create($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        if ($this->auth->user()->role != 'admin') {
            $this->flash->addMessage('error', 'You do not have the proper permissions for this operation.');
            return $response->withRedirect($this->router->pathFor('instructors.index'));
        }

        return $this->view->render($response, 'dashboard/instructors/create.twig');
    }

    public function store($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();
        $files = $_FILES;
        $image = $files['featured'];

        $instructor = Instructor::create([
            'name' => $params['name'],
            'title' => $params['title'],
            'bio' => $params['bio'],
            'facebook' => $params['facebook'],
            'twitter' => $params['twitter'],
            'instagram' => $params['instagram'],
        ]);

        if (!file_exists(__DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id);
            $instructor->avatar = $instructor->id;
            copy(__DIR__ . '/../../../assets/uploads/instructors/featured.jpg', __DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id . '/featured.jpg');
            $instructor->save();
        }

        if ($image['tmp_name'] != "") {
            move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id . '/featured.jpg');
        }

        $instructor->save();

        $this->flash->addMessage('info', 'Instructor Added!');
        return $response->withRedirect($this->router->pathFor('instructors.index'));
    }

    public function edit($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $instructor = Instructor::where('id', $args['id'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/instructors/' . $instructor->id . '/featured.jpg')) {
            $featured = '/assets/uploads/instructors/' . $instructor->id . '/featured.jpg';
        }

        return $this->view->render($response, 'dashboard/instructors/edit.twig', compact('instructor', 'featured'));
    }

    public function update($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();
        $files = $_FILES;
        $image = $files['featured'];
        $instructor = Instructor::where('id', $args['id'])->first();
        $id = $instructor->id;

        $instructor->name = $params['name'];
        $instructor->title = $params['title'];
        $instructor->bio = $params['bio'];
        $instructor->facebook = $params['facebook'];
        $instructor->twitter = $params['twitter'];
        $instructor->instagram = $params['instagram'];

        $instructor->save();

        if(!file_exists(__DIR__ . '/../../../assets/uploads/instructors/' . $id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/instructors/' . $id);
            $instructor->avatar = $id;
            $instructor->save();
        }

        move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/instructors/' . $id . '/featured.jpg');

        $this->flash->addMessage('info', 'Instructor Edited!');

        return $response->withRedirect($this->router->pathFor('instructors.view', ['id' => $id]));
    }

    public function delete($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }
        if ($this->auth->user()->role != 'admin') {
            $this->flash->addMessage('error', 'You do not have the proper permissions for this operation.');
            return $response->withRedirect($this->router->pathFor('instructors.index'));
        }

        $instructor = Instructor::find($args['id']);
        $instructor->delete();

        $this->flash->addMessage('info', 'Instructor Deleted!');
        return $response->withRedirect($this->router->pathFor('instructors.index'));
    }
}

