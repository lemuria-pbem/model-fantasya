<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Highland;

final class FireElemental extends AbstractElemental
{
	public final const LANDSCAPES = [Desert::class, Highland::class];

	private const WEIGHT = 3 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
