<?php


namespace HalloVerden\AccessDefinitionsBundle\Interfaces;


use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

/**
 * Interface AccessDefinitionAccessDeciderServiceInterface
 *
 * @package HalloVerden\AccessDefinitionsBundle\Interfaces
 */
interface AccessDefinitionAccessDeciderServiceInterface {

  /**
   * @param AccessDefinitionMetadata|null $metadata
   *
   * @return bool
   */
  public function hasAccessDefinedAccess(?AccessDefinitionMetadata $metadata): bool;

}
