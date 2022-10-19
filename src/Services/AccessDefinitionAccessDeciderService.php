<?php


namespace HalloVerden\AccessDefinitionsBundle\Services;


use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionAccessDeciderServiceInterface;
use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use HalloVerden\AccessDefinitionsBundle\Strategy\AffirmativeStrategy;
use HalloVerden\AccessDefinitionsBundle\Strategy\StrategyInterface;

/**
 * Class AccessDefinitionAccessDeciderService
 *
 * @package HalloVerden\AccessDefinitionsBundle\Services
 */
class AccessDefinitionAccessDeciderService implements AccessDefinitionAccessDeciderServiceInterface {
  private readonly StrategyInterface $defaultStrategy;
  private readonly array $strategies;

  /**
   * AccessDefinitionAccessDeciderService constructor.
   */
  public function __construct(
    iterable $strategies,
    string $defaultStrategy = AffirmativeStrategy::NAME,
  ) {
    $this->strategies = $strategies instanceof \Traversable ? \iterator_to_array($strategies) : (array) $strategies;
    $this->defaultStrategy = $this->strategies[$defaultStrategy] ?? throw new \LogicException(\sprintf('Strategy %s is not defined', $defaultStrategy));
  }

  /**
   * @inheritDoc
   */
  public function hasAccessDefinedAccess(?AccessDefinitionMetadata $metadata): bool {
    // Nothing specified = access NOT granted.
    if (null === $metadata) {
      return false;
    }

    return $this->getStrategy($metadata)->hasAccessDefinedAccess($metadata);
  }

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return StrategyInterface
   */
  private function getStrategy(AccessDefinitionMetadata $metadata): StrategyInterface {
    if (null !== $metadata->strategy) {
      return $this->strategies[$metadata->strategy];
    }

    return $this->defaultStrategy;
  }

}
