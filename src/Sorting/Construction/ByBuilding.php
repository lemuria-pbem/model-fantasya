<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Construction;

use function Lemuria\getClass;
use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Building\Acropolis;
use Lemuria\Model\Fantasya\Building\AlchemyKitchen;
use Lemuria\Model\Fantasya\Building\Blacksmith;
use Lemuria\Model\Fantasya\Building\Cabin;
use Lemuria\Model\Fantasya\Building\CamelBreeding;
use Lemuria\Model\Fantasya\Building\Canal;
use Lemuria\Model\Fantasya\Building\Citadel;
use Lemuria\Model\Fantasya\Building\College;
use Lemuria\Model\Fantasya\Building\Dockyard;
use Lemuria\Model\Fantasya\Building\Fort;
use Lemuria\Model\Fantasya\Building\GriffinBreeding;
use Lemuria\Model\Fantasya\Building\HorseBreeding;
use Lemuria\Model\Fantasya\Building\Lighthouse;
use Lemuria\Model\Fantasya\Building\Magespire;
use Lemuria\Model\Fantasya\Building\Market;
use Lemuria\Model\Fantasya\Building\Megapolis;
use Lemuria\Model\Fantasya\Building\Mine;
use Lemuria\Model\Fantasya\Building\Monument;
use Lemuria\Model\Fantasya\Building\Palace;
use Lemuria\Model\Fantasya\Building\Pit;
use Lemuria\Model\Fantasya\Building\Port;
use Lemuria\Model\Fantasya\Building\Quarry;
use Lemuria\Model\Fantasya\Building\Quay;
use Lemuria\Model\Fantasya\Building\Ruin;
use Lemuria\Model\Fantasya\Building\Saddlery;
use Lemuria\Model\Fantasya\Building\Sawmill;
use Lemuria\Model\Fantasya\Building\Shack;
use Lemuria\Model\Fantasya\Building\Signpost;
use Lemuria\Model\Fantasya\Building\Site;
use Lemuria\Model\Fantasya\Building\Stronghold;
use Lemuria\Model\Fantasya\Building\Tavern;
use Lemuria\Model\Fantasya\Building\Tower;
use Lemuria\Model\Fantasya\Building\Workshop;
use Lemuria\Model\Fantasya\Construction;

/**
 * An ordering for estate by their building type and size.
 */
class ByBuilding implements EntityOrder
{
	protected const ORDER = [
		Monument::class,
		Megapolis::class, Acropolis::class, Citadel::class, Stronghold::class, Palace::class, Tower::class, Fort::class, Site::class,
		Market::class, Magespire::class, College::class, Tavern::class,
		AlchemyKitchen::class, Blacksmith::class, Saddlery::class, Workshop::class,
		Cabin::class, Sawmill::class, Shack::class, Quarry::class, Pit::class, Mine::class,
		HorseBreeding::class, CamelBreeding::class, GriffinBreeding::class,
		Lighthouse::class, Port::class, Dockyard::class, Quay::class, Canal::class,
		Ruin::class, Signpost::class
	];

	/**
	 * @return int[]
	 */
	public function sort(EntitySet $set): array {
		$buildings = [];
		$n         = 0;
		foreach ($set as $construction /* @var Construction $construction */) {
			$building = getClass($construction->Building());
			$size     = $construction->Size();
			if (!isset($buildings[$building][$size])) {
				$buildings[$building][$size] = [];
			}
			$buildings[$building][$size][] = $construction->Id()->Id();
			$n++;
		}

		$sorted = [];
		foreach (self::ORDER as $class) {
			$building = getClass($class);
			if (isset($buildings[$building])) {
				$sizes = $buildings[$building];
				krsort($sizes);
				foreach ($sizes as $ids) {
					sort($ids);
					foreach ($ids as $id) {
						$sorted[] = $id;
					}
				}
			}
		}

		if (count($sorted) !== $n) {
			throw new LemuriaException('There is a building that is not supported yet.');
		}
		return $sorted;
	}
}
