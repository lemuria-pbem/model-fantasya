<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape\Lake;
use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class WaterElemental extends AbstractElemental
{
	/**
	 * @type array<string>
	 */
	public final const array LANDSCAPES = [Lake::class, Ocean::class, Swamp::class];

	private const int WEIGHT = 30 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}
}
