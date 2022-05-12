<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Glacier;

final class AirElemental extends AbstractElemental
{
	public final const LANDSCAPES = [Forest::class, Glacier::class];

	private const WEIGHT = 20 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
