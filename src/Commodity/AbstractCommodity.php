<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\SingletonSet;

abstract class AbstractCommodity
{
	use BuilderTrait;

	/**
	 * @type array<string>
	 */
	private const array RESOURCES = [Iron::class, Stone::class, Wood::class];

	private static ?SingletonSet $resources = null;

	public static function resources(): SingletonSet {
		if (!self::$resources) {
			self::$resources = new SingletonSet();
			foreach (self::RESOURCES as $class) {
				self::$resources->add(self::createCommodity($class));
			}
		}
		return self::$resources;
	}
}
