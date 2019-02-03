<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/mentor")
 */
class MentorController extends AbstractController {
    /**
     * @Route("/", name="mentor.students")
     */
    public function show_student_list() {
        return $this->render("mentor/studenti.html.twig");
    }

    /**
     * @Route("/predmeti", name="mentor.subjects")
     */
    public function show_subject_list() {
        return $this->render("mentor/predmeti.html.twig");
    }

    /**
     * @Route("/student/{id}", name="mentor.enrolmentForm")
     */
    public function show_enrolment_form($id) {
        return $this->render("mentor/upisniList.html.twig");
    }
}
