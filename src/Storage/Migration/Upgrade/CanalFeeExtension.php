<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration\Upgrade;

use Lemuria\Model\Fantasya\Extension\Fee;
use Lemuria\Model\Fantasya\Extensions;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;
use Lemuria\Model\Game;

class CanalFeeExtension extends AbstractUpgrade
{
	protected string $before = '1.2.2';

	protected string $after = '1.2.4';

	private array $extensions;

	public function __construct(Game $game) {
		parent::__construct($game);
		$extensions = new Extensions();
		$extensions->add(new Fee());
		$this->extensions = $extensions->serialize();
	}

	public function upgrade(): static {
		$constructions = $this->game->getConstructions();
		foreach ($constructions as $c => $construction) {
			if ($construction['building'] === 'Canal') {
				$extensions = $construction['extensions'];
				foreach ($this->extensions as $class => $extension) {
					if (!isset($extensions[$class])) {
						$extensions[$class] = $extension;
					}
				}
				$constructions[$c]['extensions'] = $extensions;
			}
		}
		$this->game->setConstructions($constructions);
		return $this->finish();
	}
}
