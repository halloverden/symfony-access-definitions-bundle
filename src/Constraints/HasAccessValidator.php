<?php


namespace HalloVerden\AccessDefinitionsBundle\Constraints;

use HalloVerden\AccessDefinitionsBundle\Services\AccessDefinitionService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class HasAccessValidator
 * @package HalloVerden\Security\AccessDefinitions\Constraints
 */
class HasAccessValidator extends ConstraintValidator {

  /**
   * HasAccessValidator constructor.
   */
  public function __construct(private readonly AccessDefinitionService $accessDefinitionService) {
  }

  /**
   * @param mixed $value
   * @param Constraint $constraint
   */
  public function validate(mixed $value, Constraint $constraint) {
    if (!$constraint instanceof HasAccess) {
      throw new UnexpectedTypeException($constraint, HasAccess::class);
    }

    $context = $this->context;

    $property = $constraint->property ?: $context->getPropertyName();
    $class = $constraint->class ?: $context->getClassName();

    if (null === $class) {
      throw new \RuntimeException('Class not found, please specify class');
    }

    if (!class_exists($class)) {
      throw new \RuntimeException('Class ' . $class. ' does not exist');
    }

    if (null === $property) {
      throw new \RuntimeException('Property not found, please specify property');
    }

    if ($constraint->read && !$this->accessDefinitionService->canReadProperty($constraint->class, $property)) {
      $context->buildViolation($constraint->noReadAccessMessage)->setParameter('{{ property }}', $property)->setCode(HasAccess::ERROR_NO_READ_ACCESS)->addViolation();
    }

    if ($constraint->write && !$this->accessDefinitionService->canWriteProperty($constraint->class, $property)) {
      $context->buildViolation($constraint->noWriteAccessMessage)->setParameter('{{ property }}', $property)->setCode(HasAccess::ERROR_NO_WRITE_ACCESS)->addViolation();
    }
  }
}
