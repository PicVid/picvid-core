<?php
/**
 * Namespace for all Specifications of the User Entities.
 */
namespace PicVid\Domain\Specification\User;

use PicVid\Domain\Entity\IEntity;
use PicVid\Domain\Entity\User;
use PicVid\Domain\Specification\ISpecification;

/**
 * Class IsValidPassword
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification\User
 */
class IsValidPassword implements ISpecification
{
    /**
     * Method to check whether the User Entity satisfies the Specification.
     * @param IEntity $user The User Entity which will be checked.
     * @return bool The state if the User Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $user) : bool
    {
        return (($user instanceof User) && (preg_match('/^[a-zA-Z0-9!?$%&@]{8,}$/', $user->password) === 1));
    }
}
