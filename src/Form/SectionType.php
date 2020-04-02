<?php

namespace App\Form;

use App\Entity\Application;
use App\Entity\Section;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('libelle', TextType::class)
        ->add('description', TextareaType::class)
        ->add(
            'users', 
            EntityType::class,
            [
                'label' => 'Ajouter des utilisateurs à la section :',
                'class'=>User::class,
                'choice_label' => function ($user){
                    return $user->getLastName() .' '. $user->getFirstName();
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference'=>false
            ])
        ->add(
            'applications', 
            EntityType::class,
            [
                'label' => 'Ajouter des applications à la section :',
                'class'=>Application::class,
                'choice_label' => function ($application){
                    return $application->getLibelle();
                },
                'multiple' => true,
                'expanded' => true
                ])
        ->add('save', SubmitType::class, ['label' => 'Enregitrer la section'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
        ]);
    }
}
