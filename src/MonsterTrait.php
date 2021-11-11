<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

trait MonsterTrait
{
	private ?Knowledge $modifications = null;

	private ?TerrainEffect $terrainEffect = null;

	private ?Weapon $weapon = null;

	private ?Trophy $trophy = null;

	/**
	 * @var Landscape[]
	 */
	private array $environment = [];

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
}
