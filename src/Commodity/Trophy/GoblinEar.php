<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use JetBrains\PhpStorm\Pure;

/**
 * The tapered green ear of a Goblin.
 */
final class GoblinEar extends AbstractTrophy
{
	private const WEIGHT = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
