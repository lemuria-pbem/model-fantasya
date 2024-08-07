<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape;
use Lemuria\Model\Fantasya\Monster;
use Lemuria\Model\Fantasya\Race\AbstractRace;
use Lemuria\Model\Fantasya\Trophy;
use Lemuria\Model\Fantasya\Weapon;
use Lemuria\SingletonSet;

abstract class AbstractMonster extends AbstractRace implements Monster
{
	protected ?Weapon $weapon = null;

	protected ?SingletonSet $loot = null;

	protected ?Trophy $trophy = null;

	/**
	 * @var array<Landscape>
	 */
	protected array $environment = [];

	public function Block(): int {
		return 0;
	}

	public function Hunger(): int {
		return 0;
	}

	public function Refill(): float {
		return 0.0;
	}

	public function Recruiting(): int {
		return 0;
	}

	public function Weapon(): ?Weapon {
		return $this->weapon;
	}

	public function Loot(): SingletonSet {
		if (!$this->loot) {
			$this->loot = new SingletonSet();
			foreach ($this->getLoot() as $loot) {
				if ($loot instanceof SingletonSet) {
					$this->loot->fill($loot);
				} else {
					$this->loot->add($loot);
				}
			}
		}
		return $this->loot;
	}

	public function Trophy(): ?Trophy {
		return $this->trophy;
	}

	/**
	 * @return array<Landscape>
	 */
	public function Environment(): array {
		return $this->environment;
	}

	protected function mods(): array {
		return [];
	}

	protected function getLoot(): array {
		return [];
	}
}
