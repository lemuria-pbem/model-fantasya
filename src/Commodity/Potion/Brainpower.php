<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;
use Lemuria\Model\Fantasya\Commodity\Herb\Windbag;

final class Brainpower extends AbstractPotion
{
	private const LEVEL = 2;

	private const INGREDIENTS = [Rockweed::class, Waterfinder::class, Windbag::class];

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
