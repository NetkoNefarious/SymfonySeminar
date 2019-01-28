<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class StudentController {
    /**
     * @Route("register")
     */
    public function register() {
        return new Response("Registracija");
    }

    /**
     * @Route("student/upis")
     */
    public function upis() {
        return new Response("Upis predmeta");
    }

    /**
     * @Route("student/ispis")
     */
    public function ispis() {
        return new Response("Ispis predmeta");
    }

    /**
     * @Route("student/polozeno")
     */
    public function polozeno() {
        return new Response("Polozen predmet");
    }

    /**
     * @Route("student/nepol")
     */
    public function nepol() {
        return new Response("Nepolozen predmet");
    }
}