<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Landscape;
use Lemuria\Model\Fantasya\Monster;
use Lemuria\Model\Fantasya\Race\AbstractRace;
use Lemuria\Model\Fantasya\Trophy;
use Lemuria\Model\Fantasya\Weapon;

abstract class AbstractMonster extends AbstractRace implements Monster
{
	use BuilderTrait;

	protected ?Weapon $weapon = null;

	protected ?Trophy $trophy = null;

	protected array $environment = [];

	#[Pure] public function Block(): int {
		return 0;
	}

	#[Pure] public function Hunger(): int {
		return 0;
	}

	#[Pure] public function Refill(): float {
		return 0.0;
	}

	#[Pure] public function Recruiting(): int {
		return 0;
	}

	#[Pure] public function Weapon(): ?Weapon {
		return $this->weapon;
	}

	#[Pure] public function Trophy(): ?Trophy {
		return $this->trophy;
	}

	/**
	 * @return Landscape[]
	 */
	public function Environment(): array {
		return $this->environment;
	}

	#[Pure] protected function mods(): array {
		return [];
	}
}
