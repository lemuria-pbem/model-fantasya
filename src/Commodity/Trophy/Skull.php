<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

use JetBrains\PhpStorm\Pure;

final class Skull extends AbstractTrophy
{
	private const WEIGHT = 50;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
