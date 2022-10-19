<?php

namespace HalloVerden\AccessDefinitionsBundle\Checker;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

interface MetadataCheckerInterface {

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  public function supports(AccessDefinitionMetadata $metadata) : bool;

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  public function check(AccessDefinitionMetadata $metadata): bool;

}
