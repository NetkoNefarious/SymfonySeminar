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
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mentor")
 */
class Subject2Controller extends AbstractController
{
    /**
     * @Route("/subject/create", name="mentor.subject.create")
     */
    public function create_subject(Request $request) {
        // Predmet
        $subject = new Predmet();

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
            'mode' => 'create'
        ]);
    }
}