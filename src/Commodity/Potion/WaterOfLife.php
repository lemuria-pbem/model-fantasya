<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;

final class WaterOfLife extends AbstractPotion
{
	private const LEVEL = 2;

	private const INGREDIENTS = [Elvendear::class, Knotroot::class, SpiderIvy::class];

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