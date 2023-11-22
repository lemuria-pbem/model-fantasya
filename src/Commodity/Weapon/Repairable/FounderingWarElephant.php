<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Commodity\Elephant;
use Lemuria\Model\Fantasya\Commodity\Weapon\WarElephant;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A foundering war elephant.
 */
final class FounderingWarElephant extends AbstractRepairable implements Animal
{
	private const int ELEPHANT = 1;

	public function Weight(): int {
		return WarElephant::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(WarElephant::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Riding::class;
	}

	protected function weapon(): string {
		return WarElephant::class;
	}

	protected function material(): array {
		return [self::class => 1, Elephant::class => self::ELEPHANT];
	}
}
