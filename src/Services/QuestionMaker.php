<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class QuestionMaker extends AbstractController
{

    public function createQuestions(array $questions)
    {
        $form = $this->createFormBuilder()
            ->getForm();
        foreach ($questions as $question) {
            $form->add($question[0], $question[1], $question[2]);
        }

        $form->add('submit', SubmitType::class, ['label' => 'Envoyer', 'attr' => ['class' => 'btn btn-primary float-right']]);

        return $form;
    }
}