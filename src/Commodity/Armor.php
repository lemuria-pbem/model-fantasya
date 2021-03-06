<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Artifact;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Armory;

/**
 * A full body armor made of iron.
 */
final class Armor implements Artifact, Commodity
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 4;

	private const WEIGHT = 4 * 100;

	private const IRON = 5;

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
