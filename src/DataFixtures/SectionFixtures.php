<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SectionFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $sections = array(
            array(
                'libelle' =>'Assistance', 
                'description'=>'Section d\'assistance, en charge de la CSU des applications BSIF et AIFE'
            ), array(
                'libelle'=>'Paramètrage',
                'description' => 'Section en charge du paramètrage des applications'
            ), array(
                'libelle'=>'Projet et stratégies',
                'description'=>'Section en charge de la création de nouvelles applications d\'information financière')
            );
        
        $i = 1;

        foreach ($sections as $value) {

            $section = new Section ();

            $section->setLibelle($value['libelle']);
            $section->setDescription($value['description']);

            $application = $this->getReference('application'. random_int(1,4));
            $section->addApplication($application);

            $this->addReference('section'.$i, $section);

            $manager->persist($section);

            $i++;
        }

        $manager->flush();
    }
}
