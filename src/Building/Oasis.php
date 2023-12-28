<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

final class Oasis extends AbstractFarm
{
	private const int TALENT = 3;

	private const int USEFUL_SIZE = 10;

	private const int SILVER = 50;

	private const int WOOD = 3;

	private const int STONE = 5;

	private const int IRON = 1;

	public function Talent(): int {
		return self::TALENT;
	}

	public function UsefulSize(): int {
		return self::USEFUL_SIZE;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
