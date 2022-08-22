<?php


namespace HalloVerden\AccessDefinitionsBundle\Metadata;

use HalloVerden\AccessDefinitionsBundle\Trait\SetAccessDefinitionMetadataTrait;
use Metadata\MergeableClassMetadata;

/**
 * Class AccessDefinitionClassMetadata
 *
 * @package HalloVerden\AccessDefinitionsBundle\Metadata
 */
class AccessDefinitionClassMetadata extends MergeableClassMetadata {
  use SetAccessDefinitionMetadataTrait;

  public ?AccessDefinitionMetadata $canCreateEveryone = null;
  public ?AccessDefinitionMetadata $canReadEveryone = null;
  public ?AccessDefinitionMetadata $canUpdateEveryone = null;
  public ?AccessDefinitionMetadata $canDeleteEveryone = null;
  public ?AccessDefinitionMetadata $canCreateOwner = null;
  public ?AccessDefinitionMetadata $canReadOwner = null;
  public ?AccessDefinitionMetadata $canUpdateOwner = null;
  public ?AccessDefinitionMetadata $canDeleteOwner = null;

  /**
   * @param string $propertyName
   *
   * @return AccessDefinitionPropertyMetadata|null
   */
  public function getPropertyMetadata(string $propertyName): ?AccessDefinitionPropertyMetadata {
    if (isset($this->propertyMetadata[$propertyName])) {
      $propertyMetadata = $this->propertyMetadata[$propertyName];
      if ($propertyMetadata instanceof AccessDefinitionPropertyMetadata) {
        return $propertyMetadata;
      }
    }

    return null;
  }

  /**
   * @inheritDoc
   */
  public function serialize() {
    return serialize([
      $this->canCreateEveryone,
      $this->canReadEveryone,
      $this->canUpdateEveryone,
      $this->canDeleteEveryone,
      $this->canCreateOwner,
      $this->canReadOwner,
      $this->canUpdateOwner,
      $this->canDeleteOwner,
      parent::serialize()
    ]);
  }

  /**
   * @inheritDoc
   */
  public function unserialize($str) {
    $unserialized = unserialize($str);
    [
      $this->canCreateEveryone,
      $this->canReadEveryone,
      $this->canUpdateEveryone,
      $this->canDeleteEveryone,
      $this->canCreateOwner,
      $this->canReadOwner,
      $this->canUpdateOwner,
      $this->canDeleteOwner,
      $parentStr
    ] = $unserialized;

    parent::unserialize($parentStr);
  }

}
