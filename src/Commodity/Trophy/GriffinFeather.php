<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use JetBrains\PhpStorm\Pure;

/**
 * A feather from the majestic Griffin wing.
 */
final class GriffinFeather extends AbstractTrophy
{
	private const WEIGHT = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
