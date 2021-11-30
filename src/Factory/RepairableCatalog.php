<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use JetBrains\PhpStorm\Pure;

use function Lemuria\getClass;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Commodity\CarriageWreck;
use Lemuria\Model\Fantasya\Commodity\Protection\Repairable\AbstractRepairable as RepairableProtection;
use Lemuria\Model\Fantasya\Commodity\Weapon\Repairable\AbstractRepairable as RepairableWeapon;
use Lemuria\Model\Fantasya\Repairable;

class RepairableCatalog
{
	use BuilderTrait;

	private static ?array $repairable = null;

	public function __construct() {
		if (!self::$repairable) {
			self::$repairable = [];
			foreach (RepairableWeapon::all() as $repairable /* @var Repairable $repairable */) {
				$class = getClass($repairable->Commodity());
				self::$repairable[$class] = $repairable;
			}
			foreach (RepairableProtection::all() as $repairable /* @var Repairable $repairable */) {
				$class = getClass($repairable->Commodity());
				self::$repairable[$class] = $repairable;
			}
			/** @var Repairable $repairable */
			$repairable               = self::createCommodity(CarriageWreck::class);
			$class                    = getClass($repairable->Commodity());
			self::$repairable[$class] = $repairable;
		}
	}

	#[Pure] public function getRepairable(Commodity $commodity): ?Repairable {
		$class = getClass($commodity);
		return self::$repairable[$class] ?? null;
	}
}
