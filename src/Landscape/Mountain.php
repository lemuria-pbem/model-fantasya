<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * The mountain is a region for few peasants, but precious resources can be found there.
 */
final class Mountain extends AbstractLandscape
{
	private const WORKPLACES = 1000;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
