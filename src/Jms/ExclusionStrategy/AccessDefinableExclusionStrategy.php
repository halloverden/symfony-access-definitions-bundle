<?php


namespace HalloVerden\AccessDefinitionsBundle\Jms\ExclusionStrategy;


use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionServiceInterface;
use JMS\Serializer\Context;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializationContext;

class AccessDefinableExclusionStrategy implements ExclusionStrategyInterface {

  /**
   * AccessDefinableExclusionStrategy constructor.
   */
  public function __construct(private readonly AccessDefinitionServiceInterface $accessDefinitionService) {
  }

  /**
   * @inheritDoc
   */
  public function shouldSkipClass(ClassMetadata $metadata, Context $context): bool {
    return false;
  }

  /**
   * @inheritDoc
   */
  public function shouldSkipProperty(PropertyMetadata $property, Context $context): bool {
    if ($context instanceof DeserializationContext) {
      return !$this->accessDefinitionService->canWriteProperty($property->class, $property->name);
    }

    if ($context instanceof SerializationContext) {
      return !$this->accessDefinitionService->canReadProperty($property->class, $property->name);
    }

    return false;
  }

}
