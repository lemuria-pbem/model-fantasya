<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

final class ForesterLodge extends AbstractBuilding
{
	private const int TALENT = 3;

	private const int FEED = 5;

	private const int USEFUL_SIZE = 10;

	private const int SILVER = 50;

	private const int WOOD = 5;

	private const int STONE = 2;

	private const int IRON = 2;

	public function Dependency(): ?Building {
		return self::createBuilding(Tower::class);
	}

	public function Feed(): int {
		return self::FEED;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return Building::IS_FREE;
	}

	public function UsefulSize(): int {
		return self::USEFUL_SIZE;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
