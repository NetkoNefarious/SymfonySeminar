<?php

namespace App\Controller;

use App\Entity\Korisnik;
use App\Entity\Predmet;
use App\Entity\Upis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student")
 */
class StudentController extends AbstractController {

    /**
     * @Route("", name="student.enrolmentForm")
     */
    public function show_enrolment_form() {
        // Student
        $student = $this->getUser();

        // Upisi
        $enrolments = $this->getDoctrine()
            ->getRepository(Upis::class)->findBy([
                "student" => $student->getId()]);

        // Vadimo upisane i položene predmete iz upisa
        $enrol_subjects = [];
        $passed_subjects = [];
        foreach ($enrolments as $enrol) {
            if(strcasecmp($enrol->getStatus(), "passed") == 0) {
                $passed_subjects[] = $enrol->getPredmet();
            }
            $enrol_subjects[] = $enrol->getPredmet();
        }

        // Svi predmeti
        $subjects = $this->getDoctrine()
            ->getRepository(Predmet::class)
            ->findAllAndOrderByStatus($student->getStatus());

        return $this->render("student.html.twig", [
            "enrol_subjects" => $enrol_subjects,
            "passed_subjects" => $passed_subjects,
            "subjects" => $subjects,
            "student" => $student
        ]);
    }
    /**
     * @Route("/enrol/{subj}", name="student.enrolmentForm.enrol")
     */
    public function enrol_subject($subj) {
        // Student
        $student = $this->getUser();

        // Predmet
        $subject = $this->getDoctrine()
            ->getRepository(Predmet::class)->find($subj);

        // Novi upis
        $upis = new Upis();
        $upis->setStatus("enrolled");
        $upis->setStudent($student);
        $upis->setPredmet($subject);

        // Spremanje u bazu
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($upis);
        $entityManager->flush();

        // Vraćanje na upisni list
        return $this->redirectToRoute("student.enrolmentForm");
    }

    /**
     * @Route("/{id}/unenrol/{subj}", name="student.enrolmentForm.unenrol")
     */
    public function unenrol_subject($subj) {
        // Student
        $student = $this->getUser();

        // Predmet
        $subject = $this->getDoctrine()
            ->getRepository(Predmet::class)->find($subj);

        // Dohvaćanje entiteta Upis
        $upis = $this->getDoctrine()
            ->getRepository(Upis::class)->findOneBy([
                "student" => $student,
                "predmet" => $subject
            ]);

        // Brisanje iz baze
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($upis);
        $entityManager->flush();

        // Vraćanje na upisni list
        return $this->redirectToRoute("student.enrolmentForm");
    }
}