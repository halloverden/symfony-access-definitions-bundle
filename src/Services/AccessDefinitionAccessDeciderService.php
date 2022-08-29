<?php


namespace HalloVerden\AccessDefinitionsBundle\Services;


use HalloVerden\JwtAuthenticatorBundle\Security\Authenticator\Token\JwtPostAuthenticationToken;
use HalloVerden\AccessDefinitionsBundle\Interfaces\AccessDefinitionAccessDeciderServiceInterface;
use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use HalloVerden\VoterBundle\Security\SecurityInterface;
use HalloVerden\VoterBundle\Security\Voter\OauthAuthorizationVoter;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Class AccessDefinitionAccessDeciderService
 *
 * @package HalloVerden\AccessDefinitionsBundle\Services
 */
class AccessDefinitionAccessDeciderService implements AccessDefinitionAccessDeciderServiceInterface {
  private readonly SecurityInterface $security;
  private readonly ExpressionLanguage $expressionLanguage;

  /**
   * AccessDefinitionAccessDeciderService constructor.
   */
  public function __construct(SecurityInterface $security, ?ExpressionLanguage $expressionLanguage = null) {
    $this->security = $security;
    $this->expressionLanguage = $expressionLanguage ?: new ExpressionLanguage();
  }

  /**
   * @inheritDoc
   */
  public function hasAccessDefinedAccess(?AccessDefinitionMetadata $metadata): bool {
    // Nothing specified = access NOT granted.
    if (null === $metadata || (null === $metadata->method && null === $metadata->scopes && null === $metadata->roles && null === $metadata->expression)) {
      return false;
    }

    // If a method is defined, this takes precedence if true.
    if (null !== $metadata->method && is_callable($metadata->method) && ($metadata->method)($metadata)) {
      return true;
    }

    if (null !== $metadata->expression && $this->expressionLanguage->evaluate($metadata->expression, ['metadata' => $metadata])) {
      return true;
    }

    if ($this->shouldCheckScope($metadata) && !$this->security->isGranted(OauthAuthorizationVoter::OAUTH_SCOPE, $metadata->scopes)) {
      return false;
    }

    return null !== $metadata->roles && $this->security->isGrantedEitherOf($metadata->roles);
  }

  /**
   * @param AccessDefinitionMetadata $metadata
   *
   * @return bool
   */
  private function shouldCheckScope(AccessDefinitionMetadata $metadata): bool {
    $token = $this->security->getToken();
    return !empty($metadata->scopes) && $token instanceof JwtPostAuthenticationToken && null !== $token->getJwt()->getClaim('scope');
  }

}
