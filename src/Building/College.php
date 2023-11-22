<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * Units in a college are able to learn twice as fast.
 */
final class College extends AbstractBuilding
{
	private const int TALENT = 4;

	private const int UPKEEP = 500;

	private const int FEED = 50;

	private const int USEFUL_SIZE = 10;

	private const int SILVER = 500;

	private const int WOOD = 5;

	private const int STONE = 5;

	private const int IRON = 1;

	public function Dependency(): ?Building {
		return self::createBuilding(Stronghold::class);
	}

	public function Feed(): int {
		return self::FEED;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return self::UPKEEP;
	}

	public function UsefulSize(): int {
		return self::USEFUL_SIZE;
	}

	/**
	 */
	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
