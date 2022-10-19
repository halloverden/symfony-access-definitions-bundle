<?php


namespace HalloVerden\AccessDefinitionsBundle\Metadata;

/**
 * Class AccessDefinitionMetadata
 *
 * @package HalloVerden\AccessDefinitionsBundle\Metadata
 */
class AccessDefinitionMetadata {

  /**
   * @var string[]|null
   */
  public ?array $roles = null;

  /**
   * @var string[]|null
   */
  public ?array $scopes = null;

  public ?string $method = null;
  public ?string $expression = null;
  public ?string $strategy = null;

  /**
   * @param array $data
   *
   * @return AccessDefinitionMetadata
   */
  public function setMetadataFromConfigData(array $data): self {
    foreach ($data as $property => $value) {
      if (\property_exists($this, $property)) {
        $this->$property = $value;
      }
    }

    return $this;
  }

}
