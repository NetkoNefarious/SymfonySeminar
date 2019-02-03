<?php

namespace App\Controller;

use App\Entity\Predmet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController {
    /**
     * @Route("/")
     */
    public function upisni_list() {
        // Popis liste predmeta
        $neupisani_predmeti = $this->getDoctrine()
            ->getRepository(Predmet::class)
            ->findAll();

        if (!$neupisani_predmeti) {
            throw $this->createNotFoundException('Nema predmeta');
        }

        return $this->render('student/upisniList.html.twig',
            ['neupisani_predmeti' => $neupisani_predmeti]);
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