<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\SingletonSet;

trait CommodityTrait
{
	protected static function getAll(string $directory): SingletonSet {
		$set = new SingletonSet();
		foreach (glob($directory . '/*.php') as $path) {
			$file = basename($path);
			if (str_starts_with($file, 'Abstract')) {
				continue;
			}
			$class = substr($file, 0, strlen($file) - 4);
			if (self::isRealCommodity($class)) {
				$set->add($class);
			}
		}
		return $set;
	}

	protected static function isRealCommodity(string $class): bool {
		return true;
	}
}
