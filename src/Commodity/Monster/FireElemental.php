<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Highland;

final class FireElemental extends AbstractElemental
{
	public final const LANDSCAPES = [Desert::class, Highland::class];

	private const WEIGHT = 3 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}
}
