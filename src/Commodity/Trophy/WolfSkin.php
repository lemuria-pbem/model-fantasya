<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * The coat of a wolf.
 */
final class WolfSkin extends AbstractTrophy
{
	private const int WEIGHT = 50;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
