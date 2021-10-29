<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use JetBrains\PhpStorm\Pure;

/**
 * A carnassial tooth of a bear.
 */
final class Carnassial extends AbstractTrophy
{
	private const WEIGHT = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
