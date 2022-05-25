<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Protection\LeatherArmor;

/**
 * A tattered leather armor.
 */
final class TatteredLeatherArmor extends AbstractRepairable implements Armature
{
	public function Weight(): int {
		return LeatherArmor::WEIGHT;
	}

	public function Block(): int {
		return $this->reduceBlock(LeatherArmor::BLOCK);
	}

	protected function protection(): string {
		return LeatherArmor::class;
	}
}
