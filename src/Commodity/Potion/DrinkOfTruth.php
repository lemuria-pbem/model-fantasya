<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\Herb\FjordFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Flatroot;

final class DrinkOfTruth extends AbstractPotion
{
	private const LEVEL = 1;

	private const INGREDIENTS = [FjordFungus::class, Flatroot::class];

	private static ?array $ingredients = null;

	/**
	 * The potion level.
	 */
	#[Pure] public function Level(): int {
		return self::LEVEL;
	}

	/**
	 * The needed ingredients.
	 *
	 * @return Commodity[]
	 */
	public function Ingredients(): array {
		if (!self::$ingredients) {
			self::$ingredients = $this->createIngredients(self::INGREDIENTS);
		}
		return self::$ingredients;
	}
}