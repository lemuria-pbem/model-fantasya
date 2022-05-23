<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * The skull of a skeleton.
 */
final class Skull extends AbstractTrophy
{
	private const WEIGHT = 50;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
