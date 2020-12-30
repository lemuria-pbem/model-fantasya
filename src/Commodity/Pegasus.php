<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Transport;
use Lemuria\SingletonTrait;

/**
 * A pegasus.
 */
final class Pegasus implements Commodity, Transport
{
	private const PAYLOAD = 20 * 100;

	private const SPEED = 3;

	private const WEIGHT = 50 * 100;

	use SingletonTrait;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}
}
