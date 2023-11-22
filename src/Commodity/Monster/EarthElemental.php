<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;

final class EarthElemental extends AbstractElemental
{
	/**
	 * @type array<string>
	 */
	public final const array LANDSCAPES = [Mountain::class, Plain::class];

	private const int WEIGHT = 300 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}
}
