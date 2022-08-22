<?php


namespace HalloVerden\AccessDefinitionsBundle\Interfaces;

use HalloVerden\AccessDefinitionsBundle\AccessDefinedProperty;

/**
 * Interface AccessDefinableInterface
 *
 * @package HalloVerden\Security\Interfaces
 */
interface AccessDefinableInterface {

  /**
   * @return array<string, AccessDefinedProperty>
   */
  public function getAccessDefinedProperties(): array;

  /**
   * @param string $property
   * @param array  $data
   */
  public function setAccessDefinedProperty(string $property, array $data): void;

}
