<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Jewelry;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Jewelry as JewelryInterface;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Jewelry;
use Lemuria\SingletonSet;

abstract class AbstractJewelry implements JewelryInterface
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;
	use RawMaterialTrait;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	protected function getCraftTalent(): string {
		return Jewelry::class;
	}
}
