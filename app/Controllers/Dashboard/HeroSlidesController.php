<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\HeroSlide;

class HeroSlidesController extends Controller
{
    public function index($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }
        
        $slides = HeroSlide::get()->all();

        return $this->view->render($response, 'dashboard/hero-slides/index.twig', compact('slides'));
    }

    public function show($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $slide = HeroSlide::where('id', $args['slug'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/hero-slides/' . $slide->id . '/featured.png')) {
            $featured = '/assets/uploads/hero-slides/' . $slide->id . '/featured.png';
        }

        return $this->view->render($response, 'dashboard/hero-slides/view.twig', compact('slide', 'featured'));
    }

    public function edit($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $slide = HeroSlide::where('id', $args['slug'])->first();
        $featured = null;

        if (file_exists(__DIR__ . '/../../../assets/uploads/hero-slides/' . $slide->id . '/featured.png')) {
            $featured = '/assets/uploads/hero-slides/' . $slide->id . '/featured.png';
        }

        return $this->view->render($response, 'dashboard/hero-slides/edit.twig', compact('slide', 'featured'));
    }

    public function update($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $params = $request->getParams();
        $files = $_FILES;
        $image = $files['featured'];
        $slide = HeroSlide::where('id', $args['slug'])->first();
        $id = $slide->id;

        $slide->heading = $params['heading'];
        $slide->subtitle = $params['subtitle'];
        $slide->description = $params['description'];
        $slide->link_name = $params['link_name'];
        $slide->link = $params['link'];

        $slide->save();

        if (!file_exists(__DIR__ . '/../../../assets/uploads/hero-slides/' . $slide->id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/hero-slides/' . $slide->id);
            $slide->image = $slide->id;
            $slide->save();
        }

        move_uploaded_file($image['tmp_name'], __DIR__ . '/../../../assets/uploads/hero-slides/' . $slide->id . '/featured.png');

        $this->flash->addMessage('info', 'Slide Edited!');

        return $response->withRedirect($this->router->pathFor('hero.view', ['slug' => $slide->id]));
    }
}

