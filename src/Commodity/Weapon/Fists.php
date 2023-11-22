<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Damage;

/**
 * Fists are the default weapon of a unit that has no real weapon.
 */
final class Fists extends NativeMelee
{
	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 5, 0];

	public function __construct() {
		parent::__construct(1, new Damage(...self::DAMAGE));
	}
}
