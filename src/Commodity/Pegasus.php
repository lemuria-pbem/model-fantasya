<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Transport;
use Lemuria\SingletonTrait;

/**
 * A pegasus.
 */
final class Pegasus implements Animal, Transport
{
	use SingletonTrait;

	private const int PAYLOAD = 20 * 100;

	private const int SPEED = 3;

	private const int WEIGHT = 50 * 100;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}
}
