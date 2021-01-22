<?php

namespace App\DataFixtures;

use App\Entity\Candidature;
use App\Entity\Job;
use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $slugger;
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        //$this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;

    }




    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $userList = [];
        $jobList = [];
        
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstname);
            $user->setLastname($faker->firstname);
            $user->setEmail($faker->email);
            $user->setCity($faker->city);
            $user->setDistrict($faker->departmentName);
            $user->setPhone($faker->mobileNumber);
            $user->setCountry($faker->country);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'team'
                ));
                $userList[] = $user;
                $manager->persist($user);
            // $user->setIsActive($faker->boolean(50));
            // $user->setIsBanned($faker->boolean(50));
        }

        for ($i = 0; $i < 10; $i++) {
            
            $job = new Job();
            $job->setTitle($faker->jobTitle);
            $job->setDescription($faker->text(430));
            $job->setSalary($faker->numerify('#####'));
            $job->setCity($faker->city);
            $job->setCompanyName($faker->company);
            $job->setDistrict($faker->departmentName);
            $job->setStartAt($faker->dateTimeInInterval('now',' + 30 days ' ));

            $jobList[] = $job;
            $manager->persist($job);
        }

        for ($m = 0; $m < 20; $m++) {
            $candidature = new Candidature ;
            for ($j = 0; $j < mt_rand(1, 3); $j++) {
                //Get a random user
                $candidate = $userList[mt_rand(0, count($userList) - 1)];
                //Get a random job
                $job = $jobList[mt_rand(0, count($jobList) - 1)];
                if (!$candidature->getCandidate() == $candidate && !$candidature->getJob() == $job) {
                    $candidature->setCandidate($candidate);
                    $candidature->setJob($job);
                }
                $bool = $faker->boolean(50);
                if($bool){
                   $candidature->setCoverLetter($faker->text(350));
                }
                if($bool){
                    $candidature->setIsAccepted($faker->boolean(50));
                }

                $candidature->setCv($faker->word().'.pdf');                
            }
            $manager->persist($candidature);
        }

        $manager->flush();
    }
}
