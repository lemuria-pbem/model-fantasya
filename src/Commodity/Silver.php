<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\SingletonTrait;

/**
 * A silver coin.
 */
final class Silver implements Commodity
{
	private const WEIGHT = 1;

	use SingletonTrait;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
