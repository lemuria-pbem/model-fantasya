<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Party\Exploring;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

class ExploringPresetting extends AbstractUpgrade
{
	protected string $before = '1.1.0';

	protected string $after = '1.4.0';

	public function upgrade(): AbstractUpgrade {
		$parties = $this->game->getParties();
		foreach ($parties as $p => $party) {
			if (!array_key_exists('exploring', $party['presettings'])) {
				$parties[$p]['presettings']['exploring'] = Exploring::Not->name;
			}
		}
		$this->game->setParties($parties);
		return $this->finish();
	}
}
