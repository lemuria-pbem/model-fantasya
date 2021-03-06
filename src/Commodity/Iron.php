<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\RawMaterial;
use Lemuria\Model\Lemuria\RawMaterialTrait;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\SingletonTrait;

/**
 * Iron is mined in mountainous regions.
 */
final class Iron implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 5 * 100;

	private string $requirement = Mining::class;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
