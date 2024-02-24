<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\Weapon\Repairable\AbstractRepairable;
use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Weapon;
use Lemuria\SingletonSet;

/**
 * Base class for any weapon.
 */
abstract class AbstractWeapon implements Commodity, Weapon
{
	use ArtifactTrait;
	use BuilderTrait;
	use CommodityTrait;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	public static function allWithRepairables(): SingletonSet {
		return self::all()->fill(AbstractRepairable::all());
	}

	public function Hits(): int {
		return 1;
	}

	public function Interval(): int {
		return 1;
	}

	public function getSkill(): Requirement {
		$talent = self::createTalent($this->talent());
		return new Requirement($talent, 1);
	}

	protected static function isRealCommodity(string $class): bool {
		return !str_starts_with($class, 'Native');
	}

	abstract protected function talent(): string;
}
