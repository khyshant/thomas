<?php

namespace App\Handler;

use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;

class TaskHandler extends AbstractHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * TrickHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getForm(): string
    {
        // TODO: Implement getForm() method.
        return TaskType::class;
    }

    protected function process($data): void
    {
        // TODO: Implement process() method.
        if ($this->entityManager->getUnitOfWork()->getEntityState($data) === UnitOfWork::STATE_NEW) {
            $this->entityManager->persist($data);
        }
        $this->entityManager->flush();

    }

}