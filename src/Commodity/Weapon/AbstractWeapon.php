<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Weapon;

/**
 * Base class for any weapon.
 */
abstract class AbstractWeapon implements Commodity, Weapon
{
	use ArtifactTrait;
	use BuilderTrait;

	#[Pure] public function Hits(): int {
		return 1;
	}

	#[Pure] public function Interval(): int {
		return 1;
	}

	public function getSkill(): Requirement {
		$talent = self::createTalent($this->talent());
		return new Requirement($talent, 1);
	}

	#[Pure] abstract protected function talent(): string;
}
