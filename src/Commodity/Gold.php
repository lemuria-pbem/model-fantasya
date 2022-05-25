<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\RawMaterial;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\SingletonTrait;

/**
 * A gold nugget.
 */
final class Gold implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 5 * 100;

	public function IsInfinite(): bool {
		return true;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getCraftTalent(): string {
		return Mining::class;
	}
}
