<?php
/**
 * Namespace for all Specifications of the Entities.
 */
namespace PicVid\Domain\Specification;

use PicVid\Domain\Entity\IEntity;

/**
 * Class NotSpecification
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification
 */
class NotSpecification implements ISpecification
{
    /**
     * The Specification which will be used.
     * @var null|ISpecification
     */
    private $specification = null;

    /**
     * NotSpecification constructor.
     * @param ISpecification $specification The Specification which will be used.
     */
    public function __construct(ISpecification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Method to check whether the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $entity) : bool
    {
        return !$this->specification->isSatisfiedBy($entity);
    }
}