<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Models\Schedule;

class SchedulesController extends Controller
{
    public function index($request, $response, $args)
    {
        if ($this->auth->check() == false) {
            return $this->view->render($response, 'auth/login.twig');
        }

        $schedules = Schedule::get()->all();

        return $this->view->render($response, 'dashboard/schedules/index.twig', compact('schedules'));
    }

    public function update($request, $response, $args)
    {
        $newFile = $_FILES['schedule'];
        $schedule = Schedule::where('id', $args['slug'])->first();
        $id = $schedule->id;

        if (!file_exists(__DIR__ . '/../../../assets/uploads/schedules/' . $id)) {
            mkdir(__DIR__ . '/../../../assets/uploads/schedules/' . $id);
            $schedule->file = $newFile['name'];
            $schedule->save();
        }

        move_uploaded_file($newFile['tmp_name'], __DIR__ . '/../../../assets/uploads/schedules/' . $id . '/schedule.jpg');
        $schedule->file = $newFile['name'];
        $schedule->save();

        $this->flash->addMessage('info', 'Schedule Updated!');

        return $response->withRedirect($this->router->pathFor('schedules.index'));
    }
}

