<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\RawMaterial;
use Lemuria\Model\Lemuria\RawMaterialTrait;
use Lemuria\Model\Lemuria\Talent\Quarrying;
use Lemuria\SingletonTrait;

/**
 * Stone is a basic building material.
 */
final class Stone implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 60 * 100;

	private string $requirement = Quarrying::class;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
