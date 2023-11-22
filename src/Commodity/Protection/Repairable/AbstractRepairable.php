<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Protection;
use Lemuria\Model\Fantasya\Repairable;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\SingletonSet;

/**
 * Base class for any Protection.
 */
abstract class AbstractRepairable implements Commodity, Protection, Repairable
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;

	private const float EFFECTIVITY = 0.75;

	private Requirement $craft;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	public function __construct() {
		$this->craft = new Requirement(self::createTalent(Armory::class), 1);
	}

	public function Commodity(): Commodity {
		return self::createCommodity($this->protection());
	}

	public function getCraft(): Requirement {
		return $this->craft;
	}

	abstract protected function protection(): string;

	protected function material(): array {
		return [self::class => 1];
	}

	protected function reduceBlock(int $block): int {
		return (int)ceil(self::EFFECTIVITY * $block);
	}
}
