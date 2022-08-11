<?php


namespace HalloVerden\AccessDefinitionsBundle\EventListener;


use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinableInterface;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionFilterServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class AccessDefinableListener
 *
 * @package HalloVerden\SecurityBundle\EventListener
 */
class AccessDefinableListener implements EventSubscriberInterface {

  /**
   * AccessDefinableListener constructor.
   */
  public function __construct(private readonly AccessDefinitionFilterServiceInterface $accessDefinitionFilterService) {
  }

  /**
   * @inheritDoc
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::CONTROLLER_ARGUMENTS => [
        ['onKernelControllerArguments', 1024]
      ]
    ];
  }

  /**
   * @param ControllerArgumentsEvent $event
   */
  public function onKernelControllerArguments(ControllerArgumentsEvent $event) {
    $request = $event->getRequest();

    foreach ($this->getAccessDefinableAttributes($request->attributes) as $accessDefinable) {
      $this->accessDefinitionFilterService->filterAccessDefinable($accessDefinable);
    }
  }

  /**
   * @param ParameterBag $attributes
   *
   * @return AccessDefinableInterface[]
   */
  private function getAccessDefinableAttributes(ParameterBag $attributes): array {
    $e = [];

    foreach ($attributes as $attribute) {
      if ($attribute instanceof AccessDefinableInterface) {
        $e[] = $attribute;
      }
    }

    return $e;
  }

}
