<?php

namespace App\Controller;

use App\Entity\Korisnik;
use App\Entity\Predmet;
use App\Entity\Upis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mentor")
 */
class MentorController extends AbstractController {
    /**
     * @Route("/students", name="mentor.students")
     */
    public function show_student_list() {
        $students = $this->getDoctrine()
            ->getRepository(Korisnik::class)->findBy([
                "role" => "ROLE_STUDENT"
            ]);

        return $this->render("mentor/studenti.html.twig", ["students" => $students]);
    }

    /**
     * @Route("/student/{id}", name="mentor.enrolmentForm")
     */
    public function show_enrolment_form($id) {
        // Student
        $student = $this->getDoctrine()
            ->getRepository(Korisnik::class)->find($id);

        // Upisi
        $enrolments = $this->getDoctrine()
            ->getRepository(Upis::class)->findBy([
                "student" => $id]);

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
     * @Route("/student/{id}/enrol/{subj}", name="mentor.enrolmentForm.enrol")
     */
    public function enrol_subject($id, $subj) {
        // Student
        $student = $this->getDoctrine()
            ->getRepository(Korisnik::class)->find($id);

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
        return $this->redirectToRoute("mentor.enrolmentForm",
            ["id" => $id]);
    }

    /**
     * @Route("/student/{id}/unenrol/{subj}", name="mentor.enrolmentForm.unenrol")
     */
    public function unenrol_subject($id, $subj) {
        // Student
        $student = $this->getDoctrine()
            ->getRepository(Korisnik::class)->find($id);

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
        return $this->redirectToRoute("mentor.enrolmentForm",
            ["id" => $id]);
    }
}
