<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\Armor;

/**
 * A dented full body armor.
 */
final class DentedArmor extends AbstractRepairable implements Armature
{
	#[Pure] public function Weight(): int {
		return Armor::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return $this->reduceBlock(Armor::BLOCK);
	}

	#[Pure] protected function protection(): string {
		return Armor::class;
	}
}
