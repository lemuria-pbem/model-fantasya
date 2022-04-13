<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Trophy;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;

abstract class AbstractTrophy implements Trophy
{
	use CommodityTrait;
	use SingletonTrait;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}
}
