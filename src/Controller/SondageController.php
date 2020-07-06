<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\User;
use App\Services\QuestionMaker;
use App\Form\SurveyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\HttpFoundation\Request;

/**
 *  Exemple de retourner par le requête sur le champs questions de la table questionnaire :
 *           ;
 */

class SondageController extends AbstractController
{
    /**
     * @Route("/sondage/{token}", name="sondage")
     */
    public function index(Request $request, string $token = null, EntityManagerInterface $em, QuestionMaker $qm)
    {
        $repository = $em->getRepository(Sondage::class);

        /** @var Sondage $sondage */
        $sondage = $repository->findOneBy(['token' => $token]);

        $form = $qm->createQuestions($sondage->getQuestionnaire()->getQuestionsSettings());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sondage->setResponses($form->getData());
            $sondage->setCompletedAt(new \DateTime());

            $em->persist($sondage);
            $em->flush($sondage);

            return $this->redirectToRoute('formulaire_success');
        }

        return $this->render('sondage/sondage.html.twig', [
            'controller_name' => 'SondageController',
            'title' => 'Questionnaire Satisfaction Utilisateur',
            'navbar_title' => 'Questionnaire satisfaction utilisateur',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/success/", name="formulaire_success")
     */
    public function youhou()
    {
        return $this->render('sondage/sondage.html.twig', [
            'navbar_title'=>'Questionnaire Satisfaction Utilisateur',
            'title' => 'Questionnaire Satisfaction Utilisateur',
            'message_title' => 'Félicitation !',
            'message' => 'Votre participation à cette enquête à été enregistré avec succès. Vous pouvez fermer cette page. Merci.',
        ]);
    }
}
