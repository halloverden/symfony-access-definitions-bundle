<?php

namespace HalloVerden\AccessDefinitionsBundle;

use HalloVerden\AccessDefinitionsBundle\DependencyInjection\Compiler\AddExpressionLanguageProvidersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HalloVerdenAccessDefinitionsBundle extends Bundle {

  /**
   * @inheritDoc
   */
  public function build(ContainerBuilder $container) {
    parent::build($container);

    $container->addCompilerPass(new AddExpressionLanguageProvidersPass());
  }

}
