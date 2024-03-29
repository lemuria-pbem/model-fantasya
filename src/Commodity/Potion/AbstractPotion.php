<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Potion;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Alchemy;
use Lemuria\SingletonSet;

abstract class AbstractPotion implements Potion
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;
	use RawMaterialTrait;

	private const int WEIGHT = 10;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	/**
	 * Get the weight of a product.
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * The effect duration of the potion.
	 */
	public function Weeks(): int {
		return 1;
	}

	protected function getCraftTalent(): string {
		return Alchemy::class;
	}

	protected function getCraftLevel(): int {
		return $this->Level() * 2;
	}
}
