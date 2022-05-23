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
 * An elephant.
 */
final class Elephant implements Animal, RawMaterial, Transport
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const PAYLOAD = 240 * 100;

	private const SPEED = 1;

	private const WEIGHT = 240 * 100;

	private const CRAFT = 2;

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

	protected function getCraftLevel(): int {
		return self::CRAFT;
	}
}
