<?php

namespace HalloVerden\AccessDefinitionsBundle\Checker;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;

final class MethodChecker implements MetadataCheckerInterface {

  /**
   * @inheritDoc
   */
  public function supports(AccessDefinitionMetadata $metadata): bool {
    return null !== $metadata->method && is_callable($metadata->method);
  }

  /**
   * @inheritDoc
   */
  public function check(AccessDefinitionMetadata $metadata): bool {
    return ($metadata->method)($metadata);
  }

}
