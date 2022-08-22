<?php

namespace HalloVerden\AccessDefinitionsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddExpressionLanguageProvidersPass implements CompilerPassInterface {

  /**
   * @inheritDoc
   */
  public function process(ContainerBuilder $container): void {
    $jmsExpressionLanguageDefinition = $container->findDefinition('jms_serializer.expression_language');
    $jmsExpressionLanguageDefinition->addMethodCall('registerProvider', [new Reference('hallo_verden.access_definitions.expression_function_provider')]);
  }

}
