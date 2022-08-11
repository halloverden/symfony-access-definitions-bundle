<?php


namespace HalloVerden\AccessDefinitionsBundle\Metadata;

use HalloVerden\AccessDefinitionsBundle\Trait\SetAccessDefinitionMetadataTrait;
use Metadata\PropertyMetadata;

/**
 * Class AccessDefinitionPropertyMetadata
 *
 * @package HalloVerden\AccessDefinitionsBundle\Metadata
 */
class AccessDefinitionPropertyMetadata extends PropertyMetadata {
  use SetAccessDefinitionMetadataTrait;

  public ?AccessDefinitionMetadata $canReadEveryone = null;
  public ?AccessDefinitionMetadata $canWriteEveryone = null;
  public ?AccessDefinitionMetadata $canReadOwner = null;
  public ?AccessDefinitionMetadata $canWriteOwner = null;

  /**
   * @return string
   */
  public function serialize() {
    return serialize([
      $this->canReadEveryone,
      $this->canReadOwner,
      $this->canWriteEveryone,
      $this->canWriteOwner,
      parent::serialize()
    ]);
  }

  /**
   * @param string $str
   */
  public function unserialize($str) {
    $unserialized = unserialize($str);
    [
      $this->canReadEveryone,
      $this->canReadOwner,
      $this->canWriteEveryone,
      $this->canWriteOwner,
      $parentStr
    ] = $unserialized;

    parent::unserialize($parentStr);
  }

}
