<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Glacier;

final class AirElemental extends AbstractElemental
{
	/**
	 * @type array<string>
	 */
	public final const array LANDSCAPES = [Forest::class, Glacier::class];

	private const int WEIGHT = 20 * 100;

	public function __construct() {
		parent::__construct(self::LANDSCAPES);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}
}
