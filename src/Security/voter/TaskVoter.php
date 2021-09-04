<?php

namespace App\Security\voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{

    public const EDIT = 'edit';

    /**
     * @inheritDoc
     */
    protected function supports(string $attribute, $subject)
    {
        if (!$subject instanceof Task) {
            return false;
        }

        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param Task $subject
     * @param TokenInterface $token
     * @return bool|void
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        $roles = $user->getRoles();
        if(in_array("ADMIN",$roles)){
            return true;
        }
        switch ($attribute) {

            case self::EDIT:
                return $user === $subject->getUser();
                break;
        }
    }
}