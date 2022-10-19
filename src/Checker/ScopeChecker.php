<?php

namespace HalloVerden\AccessDefinitionsBundle\Checker;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use HalloVerden\JwtAuthenticatorBundle\Security\Authenticator\Token\JwtPostAuthenticationToken;
use HalloVerden\VoterBundle\Security\SecurityInterface;
use HalloVerden\VoterBundle\Security\Voter\OauthAuthorizationVoter;

final class ScopeChecker implements MetadataCheckerInterface {

  /**
   * ScopeChecker constructor.
   */
  public function __construct(private readonly SecurityInterface $security) {
  }

  /**
   * @inheritDoc
   */
  public function supports(AccessDefinitionMetadata $metadata): bool {
    $token = $this->security->getToken();
    return !empty($metadata->scopes) && $token instanceof JwtPostAuthenticationToken && null !== $token->getJwt()->getClaim('scope');
  }

  /**
   * @inheritDoc
   */
  public function check(AccessDefinitionMetadata $metadata): bool {
    return $this->security->isGranted(OauthAuthorizationVoter::OAUTH_SCOPE, $metadata->scopes);
  }

}
