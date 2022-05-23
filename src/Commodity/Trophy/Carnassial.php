<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Trophy;

/**
 * A carnassial tooth of a bear.
 */
final class Carnassial extends AbstractTrophy
{
	private const WEIGHT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
