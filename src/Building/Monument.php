<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * A monument is a representational building that cannot be entered and slowly decays to a ruin if it is not rebuilt.
 */
final class Monument extends AbstractBuilding
{
	private const int TALENT = 4;

	private const int SILVER = 150;

	private const int WOOD = 1;

	private const int STONE = 1;

	private const int IRON = 1;

	public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	public function Feed(): int {
		return 0;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return 0;
	}

	public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
