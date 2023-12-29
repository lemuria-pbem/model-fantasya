<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * One of the ebony teeth of a giant sand worm.
 */
final class EbonyTooth extends AbstractTrophy
{
	private const int WEIGHT = 50;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
