<?php


namespace HalloVerden\AccessDefinitionsBundle;

/**
 * Class AccessDefinedProperty
 *
 * @package HalloVerden\AccessDefinitionsBundle
 */
class AccessDefinedProperty {

  /**
   * AccessDefinitionValueType constructor.
   */
  public function __construct(
    private readonly string $class,
    private readonly array $data,
    private readonly bool $read = false,
    private readonly bool $write = true
  ) {
  }

  /**
   * @return string
   */
  public function getClass(): string {
    return $this->class;
  }

  /**
   * @return array
   */
  public function getData(): array {
    return $this->data;
  }

  /**
   * @return bool
   */
  public function isRead(): bool {
    return $this->read;
  }

  /**
   * @return bool
   */
  public function isWrite(): bool {
    return $this->write;
  }
}
