<?php

namespace HalloVerden\AccessDefinitionsBundle\Strategy;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

final class UnanimousStrategy extends AbstractStrategy {
  const NAME = 'unanimous';

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  public function hasAccessDefinedAccess(AccessDefinitionMetadata $metadata): bool {
    $allAbstain = true;

    foreach ($this->metadataCheckers as $metadataChecker) {
      if (!$metadataChecker->supports($metadata)) {
        continue;
      }

      $allAbstain = false;

      if (!$metadataChecker->check($metadata)) {
        return false;
      }
    }

    return !$allAbstain;
  }

}
