<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Potion;
use Lemuria\SingletonTrait;

abstract class AbstractPotion implements Potion
{
	use BuilderTrait;
	use SingletonTrait;

	private const WEIGHT = 10;

	/**
	 * Get the weight of a product.
	 */
	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * @return Commodity[]
	 */
	protected function createIngredients(array $classes): array {
		$ingredients = [];
		foreach ($classes as $class) {
			$ingredients[] = self::createCommodity($class);
		}
		return $ingredients;
	}
}
