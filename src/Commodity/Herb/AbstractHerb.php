<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Herb;

use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Herb;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;

abstract class AbstractHerb implements Herb
{
	use CommodityTrait;
	use RawMaterialTrait;
	use SingletonTrait;

	private const LEVEL = 3;

	private const WEIGHT = 1;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getCraftLevel(): int {
		return self::LEVEL;
	}

	protected function getCraftTalent(): string {
		return Herballore::class;
	}
}
