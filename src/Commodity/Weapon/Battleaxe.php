<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A battleaxe.
 */
final class Battleaxe extends AbstractWeapon
{
	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

	private const IRON = 2;

	private const CRAFT = 5;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD, Iron::class => self::IRON];
	}

	#[Pure] protected function talent(): string {
		return Bladefighting::class;
	}
}
