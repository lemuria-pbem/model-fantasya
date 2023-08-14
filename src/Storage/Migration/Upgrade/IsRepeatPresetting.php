<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

class IsRepeatPresetting extends AbstractUpgrade
{
	protected string $before = '1.0.0';

	protected string $after = '1.1.0';

	public function upgrade(): static {
		$parties = $this->game->getParties();
		foreach ($parties as $p => $party) {
			if (!array_key_exists('isRepeat', $party['presettings'])) {
				$parties[$p]['presettings']['isRepeat'] = false;
			}
		}
		$this->game->setParties($parties);
		return $this->finish();
	}
}
