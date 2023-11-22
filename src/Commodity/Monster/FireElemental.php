<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Highland;

final class FireElemental extends AbstractElemental
{
	/**
	 * @type array<string>
	 */
	public final const array LANDSCAPES = [Desert::class, Highland::class];

	private const int WEIGHT = 3 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}
}
