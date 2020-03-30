<?php

namespace App\DataFixtures;

use App\Entity\Sondage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SondageFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct(){
        $this->faker = Factory::create();
    }
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 30; $i++) { 
            
            $sondage = new Sondage();

            $sondage->setToken($i);

            $rand_user = random_int(0,14);
            $user = $this->getReference('user'. $rand_user);

            $sondage->setCreatedBy($user);

            $sondage->setEmailInterviewed($this->faker->firstName() .'.'. $this->faker->lastName() .'@user.com');

            $rand_questionnaire = random_int(0, 2);
            $questionnaire = $this->getReference('questionnaire'.$rand_questionnaire);
            $sondage->setQuestionnaire($questionnaire);

            $manager->persist($sondage);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            QuestionnaireFixtures::class,
        );
    }
}
