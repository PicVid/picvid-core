<?php
/**
 * Namespace for all Specifications of the Entities.
 */
namespace PicVid\Domain\Specification;

use PicVid\Domain\Entity\IEntity;

/**
 * Class CompositeSpecification
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification
 */
class CompositeSpecification implements ISpecification
{
    /**
     * The Specifications which will be used.
     * @var array
     */
    private $specifications = [];

    /**
     * CompositeSpecification constructor.
     * @param ISpecification[] ...$specifications The Specifications which will be used.
     */
    public function __construct(ISpecification ...$specifications)
    {
        foreach ($specifications as $specification) {
            if ($specification instanceof ISpecification) {
                $this->specifications[] = $specification;
            }
        }
    }

    /**
     * Method to check whether the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $entity) : bool
    {
        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($entity)) {
                return false;
            }
        }

        return true;
    }
}
