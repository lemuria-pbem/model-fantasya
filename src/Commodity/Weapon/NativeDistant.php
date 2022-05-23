<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Talent\Stoning;

/**
 * This is a generic distant weapon used as a default for units that carry no other weapon.
 */
class NativeDistant extends Native
{
	protected function talent(): string {
		return Stoning::class;
	}
}
