<?php

namespace HalloVerden\AccessDefinitionsBundle\Checker;

use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use HalloVerden\Contracts\Oidc\Tokens\OidcTokenInterface;
use HalloVerden\JwtAuthenticatorBundle\Security\JwtPostAuthenticationToken;
use HalloVerden\VoterBundle\Security\SecurityInterface;

final class RoleChecker implements MetadataCheckerInterface {

  /**
   * RoleChecker constructor.
   */
  public function __construct(private readonly SecurityInterface $security) {
  }

  /**
   * @inheritDoc
   */
  public function supports(AccessDefinitionMetadata $metadata): bool {
    $token = $this->security->getToken();
    return !empty($metadata->roles)
      && !($token instanceof JwtPostAuthenticationToken && OidcTokenInterface::TYPE_ACCESS_CLIENT_CREDENTIALS === $token->getJwt()->getClaim('type'));
  }

  /**
   * @inheritDoc
   */
  public function check(AccessDefinitionMetadata $metadata): bool {
    return $this->security->isGrantedEitherOf($metadata->roles);
  }

}
