<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MentorController {
    /**
     * @Route("mentor/students")
     */
    public function show_student_list() {
        return new Response("Lista studenata");
    }

    /**
     * @Route("mentor/subjects")
     */
    public function show_subject_list() {
        return new Response("Lista predmeta");
    }

    /**
     * @Route("mentor/student/{id}")
     */
    public function change_student_enrolment() {
        return new Response("Promjena upisa za bilo kojeg studenta");
    }
}

