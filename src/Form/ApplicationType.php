<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Section;
use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class)
            ->add('description', TextareaType::class)
            ->add(
                'sections',
                EntityType::class,
                [
                    'label'  => 'Ajouter les sections travaillant avec l\'application.',
                    'class' => Section::class,
                    'choice_label' => function ($section){
                        return $section->getLibelle();
                    },
                    'multiple' => true,
                    'expanded' => true,
                    'by_reference'=>false
                ])
            ->add('users',
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
            ->add('save', SubmitType::class, ['label' => 'Enregistrer l\'application'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
