<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Material;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\SingletonTrait;

/**
 * Stone is a basic building material.
 */
final class Stone implements Material, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const int WEIGHT = 60 * 100;

	/**
	 * Check if this raw material is available in infinite amounts.
	 */
	public function IsInfinite(): bool {
		return true;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getCraftTalent(): string {
		return Quarrying::class;
	}
}
