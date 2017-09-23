<?php
/**
 * Namespace for all Specifications of the User Entities.
 */
namespace PicVid\Domain\Specification\User;

use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Repository\UserRepository;
use PicVid\Domain\Specification\ISpecification;

/**
 * Class IsUniqueEmail
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification\User
 */
class IsUniqueEmail implements ISpecification
{
    /**
     * Method to check whether the User Entity satisfies the Specification.
     * @param IEntity $user The User Entity which will be checked.
     * @return bool The state if the User Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $user): bool
    {
        //check if the Entity is an User Entity.
        if (!($user instanceof User)) {
            return false;
        }

        //return the state if an User Entity with the email already exists.
        return (count(UserRepository::build()->findByEmail($user->email)) === 0);
    }
}