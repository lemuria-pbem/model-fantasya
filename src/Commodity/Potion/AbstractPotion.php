<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Potion;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Alchemy;

abstract class AbstractPotion implements Potion
{
	use ArtifactTrait;
	use BuilderTrait;

	private const WEIGHT = 10;

	/**
	 * Get the weight of a product.
	 */
	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Alchemy::class);
		return new Requirement($weaponry, $this->Level() * 2);
	}
}
