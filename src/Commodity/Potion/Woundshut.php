<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;

final class Woundshut extends AbstractPotion
{
	private const LEVEL = 3;

	private const INGREDIENTS = [CaveLichen::class, Peyote::class, TangyTemerity::class, WhiteHemlock::class];

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
