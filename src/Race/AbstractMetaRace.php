<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Knowledge;
use Lemuria\Model\Fantasya\Race;
use Lemuria\Model\Fantasya\TerrainEffect;
use Lemuria\SingletonTrait;

abstract class AbstractMetaRace implements Race
{
	use SingletonTrait;

	private ?Knowledge $modifications = null;

	private ?TerrainEffect $terrainEffect = null;

	#[Pure] public function Hitpoints(): int {
		return 0;
	}

	#[Pure] public function Hunger(): int {
		return 0;
	}

	#[Pure] public function Refill(): float {
		return 0.0;
	}

	public function Modifications(): Knowledge {
		if (!$this->modifications) {
			$this->modifications = new Knowledge();
		}
		return $this->modifications;
	}

	public function TerrainEffect(): TerrainEffect {
		if (!$this->terrainEffect) {
			$this->terrainEffect = new TerrainEffect();
		}
		return $this->terrainEffect;
	}

	#[Pure] public function Recruiting(): int {
		return 0;
	}

	#[Pure] public function Weight(): int {
		return 0;
	}

	#[Pure] public function Payload(): int {
		return 0;
	}

	#[Pure] public function Speed(): int {
		return 0;
	}
}
