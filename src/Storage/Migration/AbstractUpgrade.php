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

	abstract public function upgrade(): static;

	public function isPending(string $version): bool {
		return version_compare($version, $this->before) >= 0 && version_compare($version, $this->after) < 0;
	}

	protected function finish(): static {
		$calendar = $this->game->getCalendar();
		if (version_compare($calendar['version'], $this->after) < 0) {
			$calendar['version'] = $this->after;
			$this->game->setCalendar($calendar);
		}
		return $this;
	}
}
