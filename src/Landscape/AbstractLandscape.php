<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Herb;
use Lemuria\Model\Fantasya\Landscape;
use Lemuria\SingletonTrait;

/**
 * Base class for all landscapes.
 */
abstract class AbstractLandscape implements Landscape
{
	use BuilderTrait;
	use SingletonTrait;

	/**
	 * @return array<Herb>
	 */
	protected function createHerbs(array $classes): array {
		$herbs = [];
		foreach ($classes as $class) {
			$herbs[] = self::createCommodity($class);
		}
		return $herbs;
	}
}
