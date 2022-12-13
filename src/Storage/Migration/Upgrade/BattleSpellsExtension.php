<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

class BattleSpellsExtension extends AbstractUpgrade
{
	protected string $before = '1.1.0';

	protected string $after = '1.2.0';

	public function upgrade(): AbstractUpgrade {
		$units = $this->game->getUnits();
		foreach ($units as $u => $unit) {
			if (array_key_exists('battleSpells', $unit)) {
				$battleSpells = $unit['battleSpells'];
				$extensions   = $unit['extensions'];
				unset($units[$u]['battleSpells']);
				if (array_key_exists('battleSpells', $extensions)) {
					continue;
				}
				if ($battleSpells) {
					$extensions['BattleSpells'] = $battleSpells;
					$units[$u]['extensions']    = $extensions;
				}
			}
		}
		$this->game->setUnits($units);
		return $this->finish();
	}
}
