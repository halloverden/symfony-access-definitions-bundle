<?php


namespace HalloVerden\AccessDefinitionsBundle\Interfaces;

/**
 * Interface AccessDefinitionOwnerInterface
 *
 * @package HalloVerden\Security\Interfaces
 */
interface AccessDefinitionOwnerInterface {

  /**
   * @param AccessDefinitionOwnerInterface $owner
   *
   * @return bool
   */
  public function isEqualToAccessDefinitionOwner(AccessDefinitionOwnerInterface $owner): bool;

}
