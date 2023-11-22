<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * A feather from the majestic Griffin wing.
 */
final class GriffinFeather extends AbstractTrophy
{
	private const int WEIGHT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
