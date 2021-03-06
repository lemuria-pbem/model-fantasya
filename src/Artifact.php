<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Singleton;

/**
 * An artifact is everything that a unit can build.
 */
interface Artifact extends Singleton
{
	/**
	 * Get the needed craft to create this artifact.
	 */
	public function getCraft(): Requirement;

	/**
	 * Get the list of material needed to create the artifact.
	 */
	public function getMaterial(): Resources;
}
