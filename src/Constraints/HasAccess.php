<?php


namespace HalloVerden\AccessDefinitionsBundle\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * Class HasAccess
 *
 * @package HalloVerden\AccessDefinitionsBundle\Constraints
 *
 * @Annotation
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class HasAccess extends Constraint {
  const ERROR_NO_READ_ACCESS = 'a9ef0898-db41-4ecd-bd17-22534a5a35d2';
  const ERROR_NO_WRITE_ACCESS = '04a6f004-f1a1-43f5-9555-823961104aca';

  protected static $errorNames = [
    self::ERROR_NO_READ_ACCESS => 'ERROR_NO_READ_ACCESS',
    self::ERROR_NO_WRITE_ACCESS => 'ERROR_NO_WRITE_ACCESS',
  ];

  public string $noReadAccessMessage = 'No read access to property {{ property }}';
  public string $noWriteAccessMessage = 'No write access to property {{ property }}';
  public ?string $class = null;
  public ?string $property = null;
  public bool $read = false;
  public bool $write = true;

}
