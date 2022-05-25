<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\Armor;

/**
 * A dented full body armor.
 */
final class DentedArmor extends AbstractRepairable implements Armature
{
	public function Weight(): int {
		return Armor::WEIGHT;
	}

	public function Block(): int {
		return $this->reduceBlock(Armor::BLOCK);
	}

	protected function protection(): string {
		return Armor::class;
	}
}
