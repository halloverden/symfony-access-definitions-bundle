<?php


namespace HalloVerden\AccessDefinitionsBundle\Interfaces;

/**
 * Interface AccessDefinitionOwnerAwareInterface
 *
 * @package HalloVerden\Security\Interfaces
 */
interface AccessDefinitionOwnerAwareInterface {

  /**
   * @return AccessDefinitionOwnerInterface|null
   */
  public function getAccessDefinitionObjectOwner(): ?AccessDefinitionOwnerInterface;

}
