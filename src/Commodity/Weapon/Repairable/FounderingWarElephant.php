<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Elephant;
use Lemuria\Model\Fantasya\Commodity\Weapon\WarElephant;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A foundering war elephant.
 */
final class FounderingWarElephant extends AbstractRepairable
{
	private const ELEPHANT = 1;

	#[Pure] public function Weight(): int {
		return WarElephant::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return $this->createDamage(WarElephant::DAMAGE);
	}

	#[Pure] protected function craft(): string {
		return Weaponry::class;
	}

	#[Pure] protected function talent(): string {
		return Riding::class;
	}

	#[Pure] protected function weapon(): string {
		return WarElephant::class;
	}

	#[ArrayShape([self::class => "int", Elephant::class => "int"])]
	#[Pure]
	protected function material(): array {
		return [self::class => 1, Elephant::class => self::ELEPHANT];
	}
}
