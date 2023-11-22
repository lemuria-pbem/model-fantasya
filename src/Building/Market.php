<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Construction;
use Lemuria\Model\Fantasya\Extension\Market as MarketExtension;

/**
 * A market allows simplified trade between units.
 */
final class Market extends AbstractBuilding
{
	private const int TALENT = 2;

	private const int UPKEEP = 100;

	private const int SILVER = 100;

	private const int WOOD = 2;

	private const int STONE = 8;

	private const int IRON = 2;

	public function Dependency(): ?Building {
		return self::createBuilding(Tower::class);
	}

	public function Feed(): int {
		return 0;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return self::UPKEEP;
	}

	public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	public function getMarket(Construction $construction): MarketExtension {
		$extensions = $construction->Extensions();
		/** @var MarketExtension $market */
		$market = $extensions[MarketExtension::class];
		return $market;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
