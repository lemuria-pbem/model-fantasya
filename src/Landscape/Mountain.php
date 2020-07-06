<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * The mountain is a region for few peasants, but precious resources can be found there.
 */
final class Mountain extends AbstractLandscape
{
	private const WORKPLACES = 1000;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
