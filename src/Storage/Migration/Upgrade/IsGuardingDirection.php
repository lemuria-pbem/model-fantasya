<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;
use Lemuria\Model\World\Direction;

class IsGuardingDirection extends AbstractUpgrade
{
	protected string $before = '1.0.0';

	protected string $after = '1.4.3';

	public function upgrade(): static {
		$units = $this->game->getUnits();
		foreach ($units as $u => $unit) {
			if ($unit['isGuarding']) {
				$units[$u]['isGuarding'] = Direction::None->value;
			}
		}
		$this->game->setUnits($units);
		return $this->finish();
	}
}
