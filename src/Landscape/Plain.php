<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

/**
 * A plain is a relatively flat landscape.
 */
class Plain extends AbstractLandscape
{
	private const WORKPLACES = 10000;

	/**
	 * Get the number of workplaces available for peasants.
	 *
	 * @return int
	 */
	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
