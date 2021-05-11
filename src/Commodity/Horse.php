<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Transport;
use Lemuria\SingletonTrait;

/**
 * A horse.
 */
final class Horse implements Commodity, RawMaterial, Transport
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const PAYLOAD = 20 * 100;

	private const SPEED = 2;

	private const WEIGHT = 50 * 100;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}

	protected function getCraftTalent(): string {
		return Horsetaming::class;
	}
}
