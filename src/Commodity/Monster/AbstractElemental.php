<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;

abstract class AbstractElemental extends AbstractMonster
{
	private const int HITPOINTS = 300;

	private const int HITS = 5;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [2, 3, 4];

	private const int SKILL = 8;

	public function __construct(array $landscapes) {
		$this->weapon = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE), self::HITS);
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
