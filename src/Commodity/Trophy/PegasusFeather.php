<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * A feather from a Pegasus' wing.
 */
final class PegasusFeather extends AbstractTrophy
{
	private const int WEIGHT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
