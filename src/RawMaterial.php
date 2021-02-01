<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Singleton;

/**
 * Raw materials are directly produced from available resources, requiring a single talent.
 */
interface RawMaterial extends Singleton
{
	/**
	 * Get the required Talent to produce this raw material.
	 */
	public function getTalent(): Talent;
}
