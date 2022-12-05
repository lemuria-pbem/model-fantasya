<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Ability;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;

/**
 * Common base class for native weapons.
 */
abstract class Native extends AbstractWeapon
{
	public function __construct(protected int $skill, protected Damage $damage, protected int $hits = 1) {
	}

	public function Weight(): int {
		return 0;
	}

	public function Hits(): int {
		return $this->hits;
	}

	public function Damage(): Damage {
		return $this->damage;
	}

	public function Ability(): Ability {
		return new Ability(self::createTalent($this->talent()), Ability::getExperience($this->skill));
	}

	public function getCraft(): Requirement {
		$fistfight = self::createTalent($this->talent());
		return new Requirement($fistfight, 0);
	}

	protected function material(): array {
		return [];
	}
}
