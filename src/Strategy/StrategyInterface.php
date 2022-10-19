<?php

namespace HalloVerden\AccessDefinitionsBundle\Strategy;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

interface StrategyInterface {

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  public function hasAccessDefinedAccess(AccessDefinitionMetadata $metadata): bool;

}
