<?php

namespace HalloVerden\AccessDefinitionsBundle\Tests\Strategy;

use HalloVerden\AccessDefinitionsBundle\Checker\MetadataCheckerInterface;
use HalloVerden\AccessDefinitionsBundle\Metadata\AccessDefinitionMetadata;
use HalloVerden\AccessDefinitionsBundle\Strategy\AffirmativeStrategy;
use PHPUnit\Framework\TestCase;

class AffirmativeStrategyTest extends TestCase {

  public function testHasAccessDefinedAccess_OnePassedChecker_shouldReturnTrue(): void {
    $checker1 = $this->createMock(MetadataCheckerInterface::class);
    $checker1->method('supports')->willReturn(true);
    $checker1->method('check')->willReturn(false);

    $checker2 = $this->createMock(MetadataCheckerInterface::class);
    $checker2->method('supports')->willReturn(true);
    $checker2->method('check')->willReturn(true);

    $checker3 = $this->createMock(MetadataCheckerInterface::class);
    $checker3->method('supports')->willReturn(false);
    $checker3->method('check')->willReturn(false);

    $strategy = new AffirmativeStrategy([$checker1, $checker2, $checker3]);

    $hasAccess = $strategy->hasAccessDefinedAccess(new AccessDefinitionMetadata());

    $this->assertTrue($hasAccess);
  }

  public function testHasAccessDefinedAccess_NoPassedChecker_shouldReturnFalse(): void {
    $checker1 = $this->createMock(MetadataCheckerInterface::class);
    $checker1->method('supports')->willReturn(true);
    $checker1->method('check')->willReturn(false);

    $checker2 = $this->createMock(MetadataCheckerInterface::class);
    $checker2->method('supports')->willReturn(true);
    $checker2->method('check')->willReturn(false);

    $checker3 = $this->createMock(MetadataCheckerInterface::class);
    $checker3->method('supports')->willReturn(false);
    $checker3->method('check')->willReturn(false);

    $strategy = new AffirmativeStrategy([$checker1, $checker2, $checker3]);

    $hasAccess = $strategy->hasAccessDefinedAccess(new AccessDefinitionMetadata());

    $this->assertFalse($hasAccess);
  }

  public function testHasAccessDefinedAccess_AllAbstain_shouldReturnFalse(): void {
    $checker1 = $this->createMock(MetadataCheckerInterface::class);
    $checker1->method('supports')->willReturn(false);
    $checker1->method('check')->willReturn(false);

    $checker2 = $this->createMock(MetadataCheckerInterface::class);
    $checker2->method('supports')->willReturn(false);
    $checker2->method('check')->willReturn(false);

    $checker3 = $this->createMock(MetadataCheckerInterface::class);
    $checker3->method('supports')->willReturn(false);
    $checker3->method('check')->willReturn(false);

    $strategy = new AffirmativeStrategy([$checker1, $checker2, $checker3]);

    $hasAccess = $strategy->hasAccessDefinedAccess(new AccessDefinitionMetadata());

    $this->assertFalse($hasAccess);
  }

}
