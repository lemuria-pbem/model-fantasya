<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Relation;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

class MarketRelation extends AbstractUpgrade
{
	protected string $before = '1.0.0';

	protected string $after = '1.1.0';

	public function upgrade(): AbstractUpgrade {
		$parties = $this->game->getParties();
		foreach ($parties as $p => $party) {
			foreach ($party['diplomacy']['relations'] as $r => $relation) {
				$agreement = $relation['agreement'];
				$migrated  = $this->migrate($agreement);
				if ($migrated !== $agreement) {
					$parties[$p]['diplomacy']['relations'][$r]['agreement'] = $migrated;
				}
			}
		}
		$this->game->setParties($parties);
		return $this->finish();
	}

	protected function migrate(int $agreement): int {
		if ($agreement === Relation::ALL >> 1) {
			return Relation::ALL;
		}

		$low       = $agreement & Relation::MARKET - 1;
		$high      = $agreement & Relation::ALL - $low;
		$agreement = $low | $high << 1;
		return $agreement;
	}
}
