<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

final class MushroomCave extends AbstractFarm
{
	private const int SILVER = 20;

	private const int WOOD = 1;

	private const int STONE = 2;

	private const int IRON = 1;

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
