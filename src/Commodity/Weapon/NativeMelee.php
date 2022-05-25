<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Talent\Fistfight;

/**
 * This is a generic melee weapon used as a default for units that carry no other weapon.
 */
class NativeMelee extends Native
{
	protected function talent(): string {
		return Fistfight::class;
	}
}
