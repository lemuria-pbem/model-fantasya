<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

class FillEasternOcean extends AbstractUpgrade
{
	private const REGION_COUNT = 5250;

	protected string $before = '1.2.0';

	protected string $after = '1.2.9';

	public function upgrade(): static {
		$continents = $this->game->getContinents();
		$regions    = $this->game->getRegions();
		if (count($regions) > self::REGION_COUNT || count($continents[1]['landmass']) > self::REGION_COUNT) {
			throw new LemuriaException('Cannot run upgrade ' . getClass(__CLASS__) . ': There are to many regions.');
		}
		$ocean = $regions[self::REGION_COUNT - 1];
		if ($ocean['id'] !== self::REGION_COUNT) {
			throw new LemuriaException('Cannot run upgrade ' . getClass(__CLASS__) . ': Error in last region.');
		}

		$id     = self::REGION_COUNT + 1;
		$world  = $this->game->getWorld();
		$height = count($world['map']);
		for ($y = 0; $y < $height; $y++) {
			$width = count($world['map'][$y]);
			for ($x = 0; $x < $width; $x++) {
				if ($world['map'][$y][$x] === null) {
					$ocean['id']                 = $id;
					$regions[]                   = $ocean;
					$continents[1]['landmass'][] = $id;
					$world['map'][$y][$x]        = $id++;
				}
			}
		}

		$this->game->setContinents($continents);
		$this->game->setRegions($regions);
		$this->game->setWorld($world);
		return $this->finish();
	}
}
