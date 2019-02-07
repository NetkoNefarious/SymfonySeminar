<?php

namespace App\Controller;

use App\Entity\Predmet;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/mentor")
 */
class SubjectController extends AbstractController
{
    /**
     * @Route("/subjects", name="mentor.subjects")
     */
    public function show_subject_list() {
        $subjects = $this->getDoctrine()
            ->getRepository(Predmet::class)->findAll();

        return $this->render("mentor/predmeti.html.twig", ["subjects" => $subjects]);
    }

    /**
     * @Route("/subject/{id}", name="mentor.subject.return")
     */
    public function async_return_subject($id) {
        // Postavljanje serijalizacije
        $serializer = new Serializer([new ObjectNormalizer()],
            [new JsonEncoder()]);

        // Predmet
        $subject = $this->getDoctrine()
            ->getRepository(Predmet::class)->find($id);

        // Serijalizacija
        $jsonContent = $serializer->serialize($subject, 'json');
        return new Response($jsonContent);
    }

    /**
     * @Route("/subject/edit/{id}", name="mentor.subject.edit")
     */
    public function edit_subject($id, Request $request) {
        // Predmet
        $subject = $this->getDoctrine()
            ->getRepository(Predmet::class)->find($id);

        // Forma
        $form = $this->createFormBuilder($subject)
            ->add('ime', TextType::class)
            ->add('kod', TextType::class)
            ->add('program', TextareaType::class)
            ->add('bodovi', NumberType::class)
            ->add('sem_redovni', NumberType::class)
            ->add('sem_izvanredni', NumberType::class)
            ->add('izborni', ChoiceType::class, [
                'choices' => [
                    'Da' => 'da',
                    'Ne' => 'ne'
                ]
            ])
            ->add('save', SubmitType::class, ['label' => 'Spremi'])
            ->getForm();

        // Dobivaju se podaci iz requesta
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $subject = $form->getData();

            // Ažuriranje predmeta u bazi
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();

            return $this->redirectToRoute('mentor.subjects');
        }

        return $this->render('mentor/urediPredmet.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/subject/delete/{id}", name="mentor.subject.delete")
     */
    public function delete_subject($id) {
        // Predmet
        $subject = $this->getDoctrine()
            ->getRepository(Predmet::class)->find($id);

        // Brisanje predmeta u bazi
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($subject);
        $entityManager->flush();

        return $this->redirectToRoute('mentor.subjects');
    }
}