<?php


namespace HalloVerden\AccessDefinitionsBundle\Trait;

/**
 * Trait AccessDefinableTrait
 *
 * @package HalloVerden\AccessDefinitionsBundle\Trait
 */
trait AccessDefinableTrait {

  /**
   * @param string $property
   * @param array  $data
   */
  public function setAccessDefinedProperty(string $property, array $data): void {
    if (\property_exists($this, $property)) {
      $this->{$property} = $data;
    } else {
      throw new \LogicException(\sprintf('Property %s is not defined in %s', $property, get_class($this)));
    }
  }

}
