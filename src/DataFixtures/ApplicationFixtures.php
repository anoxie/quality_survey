<?php

namespace App\DataFixtures;

use App\Entity\Application;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ApplicationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $applications = array(
            array(
                'libelle'=>'CHORUS',
                'description' => 'Application de référence financière et budgétaire de l\'AIFE'
            ), array(
                'libelle'=> 'SHOGUN - RB',
                'description' => 'Application de restitution budgétaire, permettant une lecture simplifier des données budgétaires pour les centres de coûts'
            ), array(
                'libelle' => 'Calculette',
                'description'=>'Application permettant de consulter les référentiels budgétaires'
            ), array(
                'libelle' => 'Chohab',
                'description' => 'Application permettant de consulter les habilitations CHORUS, des agents'
            )
            );

            $i = 1;
        foreach ($applications as $value) {
            $application = new Application();

            $application->setLibelle($value['libelle']);
            $application->setDescription($value['description']);

            $this->addReference('application'. $i, $application);

            $manager->persist($application);
            $i++;
        }

        $manager->flush();
    }

}
