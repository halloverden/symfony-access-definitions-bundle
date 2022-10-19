<?php

namespace HalloVerden\AccessDefinitionsBundle\Checker;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

final class ExpressionChecker implements MetadataCheckerInterface {
  private readonly ExpressionLanguage $expressionLanguage;

  /**
   * ExpressionChecker constructor.
   */
  public function __construct(?ExpressionLanguage $expressionLanguage = null) {
    $this->expressionLanguage = $expressionLanguage ?? new ExpressionLanguage();
  }

  /**
   * @inheritDoc
   */
  public function supports(AccessDefinitionMetadata $metadata): bool {
    return null !== $metadata->expression;
  }

  /**
   * @inheritDoc
   */
  public function check(AccessDefinitionMetadata $metadata): bool {
    return $this->expressionLanguage->evaluate($metadata->expression, ['metadata' => $metadata]);
  }

}
