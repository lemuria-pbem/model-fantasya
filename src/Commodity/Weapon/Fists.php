<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Damage;

/**
 * Fists are the default weapon of a unit that has no real weapon.
 */
final class Fists extends NativeMelee
{
	private const DAMAGE = [1, 5, 0];

	public function __construct() {
		parent::__construct(new Damage(...self::DAMAGE));
	}
}
