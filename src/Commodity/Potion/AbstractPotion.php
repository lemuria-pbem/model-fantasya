<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Potion;
use Lemuria\Model\Fantasya\RawMaterialTrait;
use Lemuria\Model\Fantasya\Talent\Alchemy;

abstract class AbstractPotion implements Potion
{
	use ArtifactTrait;
	use BuilderTrait;
	use RawMaterialTrait;

	private const WEIGHT = 10;

	protected string $craft = Alchemy::class;

	/**
	 * Get the weight of a product.
	 */
	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * The effect duration of the potion.
	 */
	#[Pure] public function Weeks(): int {
		return 1;
	}

	protected function getCraftTalent(): string {
		return Alchemy::class;
	}

	protected function getCraftLevel(): int {
		return $this->Level() * 2;
	}
}
