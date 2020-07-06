<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * A swamp is like a plain, but there are many moors and few peasants can make it their home.
 */
final class Swamp extends AbstractLandscape
{
	private const WORKPLACES = 2000;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
