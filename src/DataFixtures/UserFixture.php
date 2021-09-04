<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\TaskRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixture extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private     $passwordHasher;


    /**
     * @var TaskRepository
     */
    private $taskRepository;

    private     $arrayTasks;

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     * @param TaskRepository $taskRepository
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher, TaskRepository $taskRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->taskRepository = $taskRepository;
        $this->arrayTasks = self::createArrayTasks();
    }

    /**
     * @return array
     */
    private static function createArrayTasks()
    {
        $tasks= [];
        for($i=1; $i<=100; $i++){
            $tasks[rand(1,15)][] = $i;
        }
        return $tasks;
    }


    public function load(ObjectManager $manager)
    {
        // l'admin
        $user = new User;
        $user->setEmail('anth.blanchard@gmail.com');
        $user->setUsername('khyshant');
        $user->setRoles(['ADMIN','USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
        $manager->persist($user);
        foreach ($this->arrayTasks[1] as $userTaskId){
            $task = $this->taskRepository->find($userTaskId);
            $user->addTask($task);
            $task->setUser($user);
            $manager->persist($task);
        }

        // lles utilisateurs
        for($i=2; $i<=15; $i++  ){
            $user = new User;
            $user->setEmail(sprintf('%dmail@test.fr',$i));
            $user->setUsername(sprintf('user%d',$i));
            $user->setRoles(['USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
            $manager->persist($user);
            foreach ($this->arrayTasks[$i] as $userTaskId){
                $task = $this->taskRepository->find($userTaskId);
                $user->addTask($task);
                $task->setUser($user);
                $manager->persist($task);
            }
        }
        $manager->flush();
    }
}
