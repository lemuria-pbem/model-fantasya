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
 * A handy shield made of wood.
 */
final class Woodshield implements Artifact, Commodity
{
	use ArtifactTrait;
	use BuilderTrait;

	private const CRAFT = 2;

	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

	private ?Requirement $craft = null;

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

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}
}
