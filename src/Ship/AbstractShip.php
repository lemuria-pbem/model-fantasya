<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity\Wood;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Ship;
use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;

/**
 * Base class for any ship.
 */
abstract class AbstractShip implements Ship
{
	use ArtifactTrait;
	use BuilderTrait;

	private Requirement $craft;

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$talent      = self::createTalent(Shipbuilding::class);
			$this->craft = new Requirement($talent, $this->shipbuildingLevel());
		}
		return $this->craft;
	}

	#[Pure] protected function material(): array {
		return [Wood::class => $this->Wood()];
	}

	#[Pure] protected function shipbuildingLevel(): int {
		return $this->Captain();
	}
}
