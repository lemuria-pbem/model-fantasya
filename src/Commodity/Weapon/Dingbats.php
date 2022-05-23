<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Damage;

/**
 * Dingbats are small stones used with the Stoning talent in last-resort distance combat.
 */
final class Dingbats extends NativeDistant
{
	private const DAMAGE = [1, 5, 0];

	public function __construct() {
		parent::__construct(new Damage(...self::DAMAGE));
	}
}
