<?php


namespace HalloVerden\AccessDefinitionsBundle\Services;


use HalloVerden\AccessDefinitionsBundle\AccessDefinedProperty;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinableInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionFilterServiceInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionServiceInterface;

/**
 * Class AccessDefinitionFilterService
 *
 * @package HalloVerden\AccessDefinitionsBundle\Services
 */
class AccessDefinitionFilterService implements AccessDefinitionFilterServiceInterface {

  /**
   * AccessDefinitionFilterService constructor.
   */
  public function __construct(private readonly AccessDefinitionServiceInterface $accessDefinitionService) {
  }

  /**
   * @inheritDoc
   */
  public function filterAccessDefinable(AccessDefinableInterface $accessDefinable): void {
    foreach ($accessDefinable->getAccessDefinedProperties() as $property => $accessDefinedProperty) {
      $accessDefinable->setAccessDefinedProperty($property, $this->filterAccessDefinedProperty($accessDefinedProperty));
    }
  }

  /**
   * @inheritDoc
   */
  public function filterAccessDefinedProperty(AccessDefinedProperty $accessDefinedProperty): array {
    $data = $accessDefinedProperty->getData();

    foreach (array_keys($data) as $property) {
      if ($accessDefinedProperty->isRead() && !$this->accessDefinitionService->canReadProperty($accessDefinedProperty->getClass(), $property)) {
        unset($data[$property]);
      }

      if ($accessDefinedProperty->isWrite() && !$this->accessDefinitionService->canWriteProperty($accessDefinedProperty->getClass(), $property)) {
        unset($data[$property]);
      }
    }

    return $data;
  }

}
