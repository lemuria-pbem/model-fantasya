<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\RawMaterial;
use Lemuria\Model\Lemuria\RawMaterialTrait;
use Lemuria\Model\Lemuria\Talent\Woodchopping;
use Lemuria\SingletonTrait;

/**
 * An oak tree, the resource for wooden materials.
 */
final class Tree implements Commodity, RawMaterial
{
	use RawMaterialTrait;
	use SingletonTrait;

	private const WEIGHT = 30 * 100;

	private string $requirement = Woodchopping::class;

	/**
	 * Get the weight of a peasant.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}
}
