<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Generator;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {

        for($i=0 ; $i < 15; $i++){
            $user = new User();

            $lastName = $this->faker->lastName();
            $firstName = $this->faker->firstName();

            $user->setEmail($firstName . $lastName .'@test.com');
            $user->setFirstName($firstName);
            $user->setLastName($lastName);

            $password = $this->encoder-> encodePassword($user, 'test');
            $user->setPassword($password);

            $section = $this->getReference('section'. random_int(1,3));
            $user->addSection($section);


            $rand_app = random_int(1,3);
            $application = $this->getReference('application'. $rand_app);
            $user->addApplication($application);
            $rand_app++;
            $application = $this->getReference('application'. $rand_app);
            $user->addApplication($application);

            $this->addReference('user'.$i, $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies(){
        return array(SectionFixtures::class,ApplicationFixtures::class);
    }

}
