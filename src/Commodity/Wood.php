<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Material;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Woodchopping;
use Lemuria\SingletonTrait;

/**
 * Wood is a basic building material.
 */
final class Wood implements Material, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const int WEIGHT = 5 * 100;

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getCraftTalent(): string {
		return Woodchopping::class;
	}
}
