<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\SingletonTrait;

/**
 * Stone is a basic building material.
 */
final class Stone implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 60 * 100;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getCraftTalent(): string {
		return Quarrying::class;
	}
}
