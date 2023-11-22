<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Knowledge;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Race;
use Lemuria\Model\Fantasya\TerrainEffect;
use Lemuria\SingletonTrait;

/**
 * Base class for all races.
 */
abstract class AbstractRace implements Race
{
	use BuilderTrait;
	use SingletonTrait;

	private const int SPEED = 1;

	private const float FLIGHT_CHANCE = 0.25;

	private ?Knowledge $modifications = null;

	private ?TerrainEffect $terrainEffect = null;

	public function FlightChance(): float {
		return self::FLIGHT_CHANCE;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	public function Modifications(): Knowledge {
		if (!$this->modifications) {
			$this->modifications = new Knowledge();
			foreach ($this->mods() as $class => $mod) {
				$talent = self::createTalent($class);
				$this->modifications->add(new Modification($talent, $mod));
			}
		}
		return $this->modifications;
	}

	public function TerrainEffect(): TerrainEffect {
		if (!$this->terrainEffect) {
			$this->terrainEffect = new TerrainEffect();
			$this->fill($this->terrainEffect);
		}
		return $this->terrainEffect;
	}

	abstract protected function mods(): array;

	protected function fill(TerrainEffect $terrainEffect): void {
	}
}
