<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Transport;
use Lemuria\SingletonTrait;

/**
 * A camel.
 */
final class Camel implements Animal, RawMaterial, Transport
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const int PAYLOAD = 40 * 100;

	private const int SPEED = 2;

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

	protected function getCraftTalent(): string {
		return Horsetaming::class;
	}
}
