<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\LeatherArmor;

/**
 * A tattered leather armor.
 */
final class TatteredLeatherArmor extends AbstractRepairable implements Armature
{
	#[Pure] public function Weight(): int {
		return LeatherArmor::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return $this->reduceBlock(LeatherArmor::BLOCK);
	}

	#[Pure] protected function protection(): string {
		return LeatherArmor::class;
	}
}
