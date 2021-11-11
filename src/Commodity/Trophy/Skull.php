<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use JetBrains\PhpStorm\Pure;

/**
 * The skull of a skeleton.
 */
final class Skull extends AbstractTrophy
{
	private const WEIGHT = 50;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
