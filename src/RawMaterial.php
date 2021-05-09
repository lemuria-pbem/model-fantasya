<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Singleton;

/**
 * Raw materials are directly produced from available resources, requiring a single talent.
 */
interface RawMaterial extends Singleton
{
	/**
	 * Get the needed craft to produce this raw material.
	 */
	public function getCraft(): Requirement;
}
