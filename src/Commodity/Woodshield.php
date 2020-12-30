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
 * A handy shield made of wood.
 */
final class Woodshield implements Artifact, Commodity
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 2;

	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

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
		return [Wood::class => self::WOOD];
	}
}
