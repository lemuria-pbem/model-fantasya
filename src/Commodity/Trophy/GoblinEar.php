<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * The tapered green ear of a Goblin.
 */
final class GoblinEar extends AbstractTrophy
{
	private const WEIGHT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
