<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A glacier is home to only a few peasants.
 */
final class Glacier extends AbstractLandscape
{
	private const WORKPLACES = 100;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
