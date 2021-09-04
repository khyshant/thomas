<?php

namespace App\Handler;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;
    /**
     * TrickHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    protected function getForm(): string
    {
        // TODO: Implement getForm() method.
        return UserType::class;
    }

    /**
     * @param User $data
     */
    protected function process($data): void
    {

        // TODO: Implement process() method.
        if ($this->entityManager->getUnitOfWork()->getEntityState($data) === UnitOfWork::STATE_NEW) {
            $data->setPassword($this->passwordHasher->hashPassword($data,$data->getPassword()));
            $this->entityManager->persist($data);
        }
        $this->entityManager->flush();
    }

}