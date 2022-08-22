<?php


namespace HalloVerden\AccessDefinitionsBundle\Jms\ExpressionLanguage\ExpressionFunction;

use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionOwnerAwareInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionOwnerInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionServiceInterface;
use JMS\Serializer\Context;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class HasAccessFunction
 *
 * @package HalloVerden\AccessDefinitionsBundle\Jms\ExpressionLanguage\ExpressionFunction
 */
class HasAccessFunction {

  /**
   * HasAccessFunction constructor.
   */
  public function __construct(
    private readonly AccessDefinitionServiceInterface $accessDefinitionService,
    private readonly TokenStorageInterface $tokenStorage
  ) {
  }

  /**
   * @param array $arguments
   *
   * @return bool
   */
  public function __invoke(array $arguments): bool {
    return $this->hasAccess(...$this->checkArguments($arguments));
  }

  /**
   * @param Context          $context
   * @param PropertyMetadata $propertyMetadata
   * @param object|null      $object
   *
   * @return bool
   */
  private function hasAccess(Context $context, PropertyMetadata $propertyMetadata, ?object $object): bool {
    if ($context instanceof DeserializationContext) {
      return $this->accessDefinitionService->canWriteProperty($propertyMetadata->class, $propertyMetadata->name, $this->isOwner($object));
    } elseif ($context instanceof SerializationContext) {
      return $this->accessDefinitionService->canReadProperty($propertyMetadata->class, $propertyMetadata->name, $this->isOwner($object));
    }

    return true;
  }

  /**
   * @param object|null $object $object
   *
   * @return bool
   */
  private function isOwner(?object $object): bool {
    if (!$object instanceof AccessDefinitionOwnerAwareInterface) {
      return false;
    }

    $owner = $object->getAccessDefinitionObjectOwner();
    $user = $this->getAuthenticatedUser();

    return null !== $owner && null !== $user && $owner->isEqualToAccessDefinitionOwner($user);
  }

  /**
   * @return AccessDefinitionOwnerInterface|null
   */
  private function getAuthenticatedUser(): ?AccessDefinitionOwnerInterface {
    $token = $this->tokenStorage->getToken();

    if (null === $token) {
      return null;
    }

    $user = $token->getUser();

    if (!$user instanceof AccessDefinitionOwnerInterface) {
      return null;
    }

    return $user;
  }

  /**
   * @param array $arguments
   *
   * @return array
   */
  private function checkArguments(array $arguments): array {
    $context = $arguments['context'] ?? null;

    if (!$context instanceof Context) {
      throw new \InvalidArgumentException(\sprintf('context missing or not instance of %s', Context::class));
    }

    $propertyMetadata = $arguments['property_metadata'] ?? null;

    if (!$propertyMetadata instanceof PropertyMetadata) {
      throw new \InvalidArgumentException(\sprintf('property_metadata missing or not instance of %s', PropertyMetadata::class));
    }

    $object = $arguments['object'] ?? null;

    return [$context, $propertyMetadata, $object];
  }

}
