<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Singleton;

/**
 * An artifact is everything that a unit can build.
 */
interface Artifact extends Singleton
{
	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement;

	/**
	 * Get the list of material needed to create the artifact.
	 *
	 * @return Resources
	 */
	public function getMaterial(): Resources;
}
