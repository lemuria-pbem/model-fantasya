<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;

final class EarthElemental extends AbstractElemental
{
	public final const LANDSCAPES = [Mountain::class, Plain::class];

	private const WEIGHT = 300 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
