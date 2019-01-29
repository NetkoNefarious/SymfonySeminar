<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PersonController {
    /**
     * @Route("login")
     */
    public function login() {
        return new Response("Dobrodošli na login");
    }
}