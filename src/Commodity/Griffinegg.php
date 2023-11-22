<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\SingletonTrait;

/**
 * A griffin egg.
 */
final class Griffinegg implements Commodity
{
	use SingletonTrait;

	private const int WEIGHT = 20 * 100;

	public function Weight(): int {
		return self::WEIGHT;
	}
}
