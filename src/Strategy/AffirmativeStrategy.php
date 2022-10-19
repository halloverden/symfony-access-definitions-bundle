<?php

namespace HalloVerden\AccessDefinitionsBundle\Strategy;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

final class AffirmativeStrategy extends AbstractStrategy {
  const NAME = 'affirmative';

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  public function hasAccessDefinedAccess(AccessDefinitionMetadata $metadata): bool {
    foreach ($this->metadataCheckers as $metadataChecker) {
      if ($metadataChecker->supports($metadata) && $metadataChecker->check($metadata)) {
        return true;
      }
    }

    return false;
  }

}
