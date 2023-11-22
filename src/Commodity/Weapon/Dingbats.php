<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Damage;

/**
 * Dingbats are small stones used with the Stoning talent in last-resort distance combat.
 */
final class Dingbats extends NativeDistant
{
	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 5, 0];

	public function __construct() {
		parent::__construct(0, new Damage(...self::DAMAGE));
	}
}
