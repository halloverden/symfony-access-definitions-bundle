<?php

namespace HalloVerden\AccessDefinitionsBundle\Strategy;

use HalloVerden\AccessDefinitionsBundle\Checker\MetadataCheckerInterface;

abstract class AbstractStrategy implements StrategyInterface {

  /**
   * @var MetadataCheckerInterface[]
   */
  protected array $metadataCheckers;

  /**
   * AbstractStrategy constructor.
   */
  public function __construct(
    iterable $metadataCheckers
  ) {
    $this->metadataCheckers = $metadataCheckers instanceof \Traversable ? \iterator_to_array($metadataCheckers) : (array) $metadataCheckers;
  }

}
