<?php
/**
 * Namespace for all Specifications of the Entities.
 */
namespace PicVid\Domain\Specification;

use PicVid\Domain\Entity\IEntity;

/**
 * Interface ISpecification
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification
 */
interface ISpecification
{
    /**
     * Method to check whether the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $entity) : bool;
}