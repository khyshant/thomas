<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Entity\User;

class TaskFixture extends Fixture
{
    private $userRepository;

    /**
     * @param UserRepository $userRepository*
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function load(ObjectManager $manager)
    {
        for($i=1; $i<=100; $i++ ){

            $task = new Task;
            $task->setTitle(sprintf('title task %d',$i));
            $task->setDescription(sprintf('description tache %d : Lorem ipsum dolor sit amet, consectetur adipiscing
             elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',$i));
            $done= rand(0,1);
            if($done = 1){
                $task->setDone(true);
                $task->setDraft(false);
            }
            else{
                $task->setDone(false);
                $draft = (bool)rand(0,1);
                $task->setDone($draft);
            }
            $manager->persist($task);
        }
        $manager->flush();
    }
}
