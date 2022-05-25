<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Knowledge;
use Lemuria\Model\Fantasya\Race;
use Lemuria\Model\Fantasya\TerrainEffect;
use Lemuria\SingletonTrait;

abstract class AbstractMetaRace implements Race
{
	use SingletonTrait;

	private ?Knowledge $modifications = null;

	private ?TerrainEffect $terrainEffect = null;

	public function Hitpoints(): int {
		return 0;
	}

	public function FlightChance(): float {
		return 0.0;
	}

	public function Hunger(): int {
		return 0;
	}

	public function Refill(): float {
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

	public function Recruiting(): int {
		return 0;
	}

	public function Weight(): int {
		return 0;
	}

	public function Payload(): int {
		return 0;
	}

	public function Speed(): int {
		return 0;
	}
}
