<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Repairable;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Weapon;
use Lemuria\SingletonSet;

/**
 * Base class for any repairable weapon.
 */
abstract class AbstractRepairable implements Commodity, Repairable, Weapon
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;

	private const REDUCTION = 0.25;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	#[Pure] public function Hits(): int {
		return 1;
	}

	#[Pure] public function Interval(): int {
		return 1;
	}

	public function Commodity(): Commodity {
		return self::createCommodity($this->weapon());
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent($this->craft());
		return new Requirement($weaponry, 1);
	}

	public function getSkill(): Requirement {
		$talent = self::createTalent($this->talent());
		return new Requirement($talent, 1);
	}

	#[Pure] abstract protected function craft(): string;

	#[Pure] abstract protected function talent(): string;

	#[Pure] abstract protected function weapon(): string;

	#[ArrayShape([self::class => "int"])]
	#[Pure]
	protected function material(): array {
		return [self::class => 1];
	}

	/**
	 * @param int[]
	 * @return Damage
	 * @noinspection PhpPureFunctionMayProduceSideEffectsInspection
	 */
	#[Pure] protected function createDamage(array $damage): Damage {
		return (new Damage(...$damage))->reducedBy(self::REDUCTION);
	}
}
