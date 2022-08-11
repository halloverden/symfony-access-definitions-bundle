<?php

namespace HalloVerden\AccessDefinitionsBundle\DependencyInjection;

use Metadata\Cache\FileCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class HalloVerdenAccessDefinitionsExtension extends Extension {

  /**
   * @inheritDoc
   * @throws \Exception
   */
  public function load(array $config, ContainerBuilder $container): void {
    $mergedConfig = $this->processConfiguration(new Configuration(), $config);

    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
    $loader->load('services.yaml');

    $container->getDefinition('hallo_verden.access_definitions.metadata.file_locator')
      ->replaceArgument('$dirs', $mergedConfig['dirs']);

    if ($mergedConfig['cache'] !== 'none') {
      $this->addCache($mergedConfig, $container);
    }
  }

  /**
   * @param array            $config
   * @param ContainerBuilder $container
   *
   * @return void
   */
  private function addCache(array $config, ContainerBuilder $container): void {
    $metadataCacheId = 'hallo_verden.access_definitions.metadata.cache';

    $container->getDefinition('hallo_verden.access_definitions.metadata.factory')
      ->addMethodCall('setCache', [new Reference($metadataCacheId)]);

    if ($config['cache'] !== 'file') {
      $container->setAlias($metadataCacheId, new Alias($config['cache']));
      return;
    }

    $dir = $container->getParameterBag()->resolveValue($config['file_cache_dir']);
    if (!\is_dir($dir) && !@\mkdir($dir, 0777, true) && !\is_dir($dir)) {
      throw new \RuntimeException(sprintf('Could not create cache directory "%s".', $dir));
    }

    $metadataFileCacheId = 'hallo_verden.access_definitions.metadata.cache.file';
    $container->setDefinition($metadataFileCacheId, new Definition(FileCache::class, [
      '$dir' => $config['file_cache_dir']
    ]));
    $container->setAlias($metadataCacheId, new Alias($metadataFileCacheId));
  }

}
