<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;

abstract class AbstractElemental extends AbstractMonster
{
	private const HITPOINTS = 300;

	private const HITS = 5;

	private const DAMAGE = [2, 3, 4];

	public function __construct(array $landscapes) {
		$this->weapon = new NativeMelee(new Damage(...self::DAMAGE), self::HITS);
		foreach ($landscapes as $landscape) {
			$this->environment[] = self::createLandscape($landscape);
		}
	}

	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	public function Payload(): int {
		return 0;
	}

	public function Recreation(): float {
		return 1.0;
	}
}
