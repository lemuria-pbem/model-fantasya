<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

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

	public function Weapon(): ?Weapon {
		return $this->weapon;
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
}
