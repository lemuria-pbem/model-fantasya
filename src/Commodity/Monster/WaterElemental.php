<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class WaterElemental extends AbstractElemental
{
	public final const LANDSCAPES = [Ocean::class, Swamp::class];

	private const WEIGHT = 30 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
