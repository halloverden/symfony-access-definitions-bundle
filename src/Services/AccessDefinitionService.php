<?php


namespace HalloVerden\AccessDefinitionsBundle\Services;


use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionAccessDeciderServiceInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionServiceInterface;
use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionClassMetadata;
use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionPropertyMetadata;
use Metadata\MetadataFactoryInterface;

/**
 * Class AccessDefinitionService
 *
 * @package HalloVerden\AccessDefinitionsBundle\Services
 */
class AccessDefinitionService implements AccessDefinitionServiceInterface {

  /**
   * AccessDefinitionService constructor.
   */
  public function __construct(
    private readonly MetadataFactoryInterface $metadataFactory,
    private readonly AccessDefinitionAccessDeciderServiceInterface $accessDeciderService,
    private readonly bool $allowNoMetadata = true
  ) {
  }

  /**
   * @inheritDoc
   */
  public function canCreate(string $class, bool $isOwner = false): bool {
    if (null === $metadata = $this->getMetadata($class)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($metadata->canCreateOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($metadata->canCreateEveryone);
  }

  /**
   * @inheritDoc
   */
  public function canRead(string $class, bool $isOwner = false): bool {
    if (null === $metadata = $this->getMetadata($class)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($metadata->canReadOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($metadata->canReadEveryone);
  }

  /**
   * @inheritDoc
   */
  public function canUpdate(string $class, bool $isOwner = false): bool {
    if (null === $metadata = $this->getMetadata($class)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($metadata->canUpdateOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($metadata->canUpdateEveryone);
  }

  /**
   * @inheritDoc
   */
  public function canDelete(string $class, bool $isOwner = false): bool {
    if (null === $metadata = $this->getMetadata($class)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($metadata->canDeleteOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($metadata->canDeleteEveryone);
  }

  /**
   * @inheritDoc
   */
  public function canReadProperty(string $class, string $property, bool $isOwner = false): bool {
    if (null === $propertyMetadata = $this->getPropertyMetadata($class, $property)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($propertyMetadata->canReadOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($propertyMetadata->canReadEveryone);
  }

  /**
   * @inheritDoc
   */
  public function canWriteProperty(string $class, string $property, bool $isOwner = false): bool {
    if (null === $propertyMetadata = $this->getPropertyMetadata($class, $property)) {
      return $this->allowNoMetadata;
    }

    if ($isOwner && $this->accessDeciderService->hasAccessDefinedAccess($propertyMetadata->canWriteOwner)) {
      return true;
    }

    return $this->accessDeciderService->hasAccessDefinedAccess($propertyMetadata->canWriteEveryone);
  }

  /**
   * @param string $class
   * @param string $property
   *
   * @return AccessDefinitionPropertyMetadata|null
   */
  private function getPropertyMetadata(string $class, string $property): ?AccessDefinitionPropertyMetadata {
    if (null === $metadata = $this->getMetadata($class)) {
      return null;
    }

    return $metadata->getPropertyMetadata($property);
  }

  /**
   * @param string $class
   *
   * @return AccessDefinitionClassMetadata|null
   */
  private function getMetadata(string $class): ?AccessDefinitionClassMetadata {
    $metadata = $this->metadataFactory->getMetadataForClass($class);

    if (!$metadata instanceof AccessDefinitionClassMetadata) {
      return null;
    }

    return $metadata;
  }

}
