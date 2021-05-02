<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

interface Potion extends Commodity
{
	/**
	 * The potion level.
	 */
	#[Pure] public function Level(): int;

	/**
	 * The needed ingredients.
	 *
	 * @return Commodity[]
	 */
	public function Ingredients(): array;
}
