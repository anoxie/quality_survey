<?php

namespace App\DataFixtures;

use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class QuestionnaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $dum_data = [
            [
                'form_test',
                TextType::class,
                [
                    'label' => 'Quel est votre nom ?',
                ]
            ], [
                'truc_bidule',
                TextareaType::class,
                [
                    'label' => 'Quel est ton âge ?',
                ]
            ], [
                'echelle_satifaction',
                ChoiceType::class,
                [
                    'label' => 'Sur une échelle de 1 à 10 évaluez votre satisfaction au regard de la prestation :',
                    'choices' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                    'multiple' => false,
                    'expanded' => true,
                    'attr' => ['class' => 'form-check-inline']
                ]
            ],
            [
                'satisfaction_quali',
                ChoiceType::class,
                [
                    'label' => 'Quels adjectifs sont les mieux à même de décrire votre entière satisfaction : (plusieurs choix possibles)',
                    'choices' => ['Fantastique' => 0, 'Merveilleux' => 1, 'Indescriptible' => 2, 'Au-delà, de toutes attentes' => 3, 'Plutôt bof' => 4],
                    'multiple' => true,
                    'expanded' => true
                ]
            ]
        ];

        for($i=0 ; $i < 3; $i++){
            $questionnaire = new Questionnaire();

            $questionnaire->setLibelle('Questionnaire '.$i);
            $questionnaire->setModelMail(
                array(
                    'subject'=>'Suivi de satisfaction utilisateur',
                    'body'=>'Coucou,
                            Je suis un test d\'email'));
            $questionnaire->setQuestionsSettings($dum_data);

                $section = $this->getReference('section'. random_int(1,3));
                $questionnaire->setSection($section);

                $rand_app = random_int(1,3);
                $application = $this->getReference('application'. $rand_app);
                $questionnaire->addApplication($application);
                $rand_app++;
                $application = $this->getReference('application'. $rand_app);
                $questionnaire->addApplication($application);

                $this->addReference('questionnaire'.$i, $questionnaire);

                $manager->persist($questionnaire);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            SectionFixtures::class,
            ApplicationFixtures::class
        );
    }
}
