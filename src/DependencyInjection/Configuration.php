<?php

namespace HalloVerden\AccessDefinitionsBundle\DependencyInjection;

use HalloVerden\AccessDefinitionsBundle\Strategy\AffirmativeStrategy;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

  /**
   * @inheritDoc
   */
  public function getConfigTreeBuilder(): TreeBuilder {
    $treeBuilder = new TreeBuilder('hallo_verden_access_definitions');

    $treeBuilder->getRootNode()
      ->addDefaultsIfNotSet()
      ->children()
        ->arrayNode('dirs')
          ->defaultValue([])
          ->scalarPrototype()->end()
        ->end()
        ->scalarNode('cache')->defaultValue('file')->end()
        ->scalarNode('file_cache_dir')->defaultValue('%kernel.cache_dir%/hallo_verden_access_definitions')->end()
        ->scalarNode('default_strategy')->defaultValue(AffirmativeStrategy::NAME)->end()
      ->end();

    return $treeBuilder;
  }

}
