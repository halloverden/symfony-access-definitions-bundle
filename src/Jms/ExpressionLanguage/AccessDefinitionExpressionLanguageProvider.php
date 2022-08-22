<?php


namespace HalloVerden\AccessDefinitionsBundle\Jms\ExpressionLanguage;

use HalloVerden\AccessDefinitionsBundle\Jms\ExpressionLanguage\ExpressionFunction\HasAccessFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * Class AccessDefinitionExpressionLanguageProvider
 *
 * @package HalloVerden\Security\AccessDefinitions\JMS\ExpressionLanguage
 */
class AccessDefinitionExpressionLanguageProvider implements ExpressionFunctionProviderInterface {

  /**
   * HasAccessExpressionLanguageProvider constructor.
   */
  public function __construct(private readonly HasAccessFunction $hasAccessFunction) {
  }

  /**
   * @inheritDoc
   */
  public function getFunctions(): array {
    return [
      new ExpressionFunction('hasAccess', function () {}, $this->hasAccessFunction)
    ];
  }

}
