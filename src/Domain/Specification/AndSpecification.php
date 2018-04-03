<?php
/**
 * Namespace for all Specifications of the Entities.
 */
namespace PicVid\Domain\Specification;

use PicVid\Domain\Entity\IEntity;

/**
 * Class AndSpecification
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Domain\Specification
 */
class AndSpecification implements ISpecification
{
    /**
     * The left Specification which will be used.
     * @var null|ISpecification
     */
    private $leftSpecification = null;

    /**
     * The right Specification which will be used.
     * @var null|ISpecification
     */
    private $rightSpecification = null;

    /**
     * AndSpecification constructor.
     * @param ISpecification $leftSpecification The left Specification which will be used.
     * @param ISpecification $rightSpecification The right Specification which will be used.
     */
    public function __construct(ISpecification $leftSpecification, ISpecification $rightSpecification)
    {
        $this->leftSpecification = $leftSpecification;
        $this->rightSpecification = $rightSpecification;
    }

    /**
     * Method to check whether the Entity satisfies the Specification.
     * @param IEntity $entity The Entity which will be checked.
     * @return bool The state if the Entity satisfies the Specification.
     */
    public function isSatisfiedBy(IEntity $entity) : bool
    {
        return $this->leftSpecification->isSatisfiedBy($entity) && $this->rightSpecification->isSatisfiedBy($entity);
    }
}
