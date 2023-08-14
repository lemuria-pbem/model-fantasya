<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;
use Lemuria\Model\World\Geometry;

class WorldGeometry extends AbstractUpgrade
{
	protected string $before = '1.1.0';

	protected string $after = '1.2.0';

	public function upgrade(): static {
		$world = $this->game->getWorld();
		if (!isset($world['geometry'])) {
			$newWorld             = ['origin' => $world['origin']];
			$newWorld['geometry'] = Geometry::Flat->value;
			$newWorld['map']      = $world['map'];
			$world                = $newWorld;
		} elseif (Geometry::from($world['geometry']) === Geometry::Spherical) {
			$h = count($world['map']);
			for ($y = 0; $y < $h; $y++) {
				if (array_sum($world['map'][$y])) {
					$w = count($world['map'][$y]);
					for ($x = 0; $x < $w; $x++) {
						if (!$world['map'][$y][$x]) {
							unset($world['map'][$y][$x]);
						}
					}
					$world['map'][$y] = array_values($world['map'][$y]);
				} else {
					unset($world['map'][$y]);
				}
			}
		}
		$this->game->setWorld($world);
		return $this->finish();
	}
}
