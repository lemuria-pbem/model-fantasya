<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Ship;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;

/**
 * Base class for any ship.
 */
abstract class AbstractShip implements Ship
{
	use ArtifactTrait;
	use BuilderTrait;

	private ?Requirement $craft = null;

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$talent      = self::createTalent(Shipbuilding::class);
			$this->craft = new Requirement($talent, $this->shipbuildingLevel());
		}
		return $this->craft;
	}

	public function Tare(): int {
		return $this->Wood() * self::createCommodity(Wood::class)->Weight();
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => 1];
	}

	#[Pure] protected function shipbuildingLevel(): int {
		return $this->Captain();
	}
}
