<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Artifact;
use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Armory;

/**
 * A chain mail.
 */
final class Mail implements Artifact, Commodity
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 3;

	private const WEIGHT = 2 * 100;

	private const IRON = 3;

	private Requirement $craft;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$armory      = self::createTalent(Armory::class);
			$this->craft = new Requirement($armory, self::CRAFT);
		}
		return $this->craft;
	}

	#[Pure] protected function material(): array {
		return [Iron::class => self::IRON];
	}
}
