<?php

namespace App\Controller;

use App\Entity\Korisnik;
use App\Entity\Predmet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mentor")
 */
class MentorController extends AbstractController {
    /**
     * @Route("/", name="mentor.students")
     */
    public function show_student_list() {
        $students = $this->getDoctrine()
            ->getRepository(Korisnik::class)->findBy([
                "role" => "student"
            ]);

        return $this->render("mentor/studenti.html.twig", ["students" => $students]);
    }

    /**
     * @Route("/predmeti", name="mentor.subjects")
     */
    public function show_subject_list() {
        $subjects = $this->getDoctrine()
            ->getRepository(Predmet::class)->findAll();

        return $this->render("mentor/predmeti.html.twig", ["subjects" => $subjects]);
    }

    /**
     * @Route("/student/{id}", name="mentor.enrolmentForm")
     */
    public function show_enrolment_form($id) {
        return $this->render("mentor/upisniList.html.twig");
    }
}
