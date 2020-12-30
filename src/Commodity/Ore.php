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
 * A pile of ore, the resource for iron.
 */
final class Ore implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 15 * 100;

	private string $requirement = Mining::class;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
