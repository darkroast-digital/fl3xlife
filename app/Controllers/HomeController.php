<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Instructor;
use App\Models\Schedule;
use App\Models\Testimony;
use PHPMailer\PHPMailer\PHPMailer;


class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $slides = HeroSlide::get()->all();
        $instructors = Instructor::get()->all();
        $testimonies = Testimony::get()->all();
        $schedules = Schedule::get()->all();

        return $this->view->render($response, 'home.twig', compact('slides', 'instructors', 'testimonies', 'schedules'));
    }

    public function trainer($request, $response, $args)
    {
        $trainer = Instructor::where('id', $args['id'])->first();

        return $this->view->render($response, 'trainer.twig', compact('trainer'));
    }

    public function post($request, $response, $args)
    {
        $mail = new PHPMailer;

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        $subject = "New message from FL3X-Life.com - $name";

        $mail->setFrom($email, $name);
        $mail->addAddress('fl3xlifefitness@gmail.com', 'FL3X Life');
        $mail->addReplyTo('fl3xlifefitness@gmail.com', 'FL3X Life');
        $mail->ReturnPath='fl3xlifefitness@gmail.com';

        $mail->isHTML(true);

        $body = "<p>Name: " . $name . "<br/>" .
                "Phone: " . $phone . "<br/>" .
                "Email: " . $email . "<br/>" .
                "Message: " . $message . "<br/>";

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $body;

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Success!';
        }

    }
}
