<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Transport;
use Lemuria\SingletonTrait;

/**
 * A griffin.
 */
final class Griffin implements Commodity, Transport
{
	private const PAYLOAD = 50 * 100;

	private const SPEED = 5;

	private const WEIGHT = 120 * 100;

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
