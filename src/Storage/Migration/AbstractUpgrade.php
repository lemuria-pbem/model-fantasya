<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Game;

abstract class AbstractUpgrade
{
	private const NAMESPACE = __NAMESPACE__ . '\\Upgrade\\';

	protected string $before;

	protected string $after;

	public static function getAll(): array {
		$upgrades = [];
		foreach (glob(__DIR__ . '/Upgrade/*.php') as $path) {
			$file       = basename($path);
			$class      = substr($file, 0, strlen($file) - 4);
			$upgrades[] = self::NAMESPACE . $class;
		}
		return $upgrades;
	}

	public function __construct(protected Game $game) {
	}

	abstract public function upgrade(): AbstractUpgrade;

	public function isPending(string $version): bool {
		return $version >= $this->before && $version < $this->after;
	}

	protected function finish(): AbstractUpgrade {
		$calendar = $this->game->getCalendar();
		if ($calendar['version'] < $this->after) {
			$calendar['version'] = $this->after;
			$this->game->setCalendar($calendar);
		}
		return $this;
	}
}
