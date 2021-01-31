<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * Materials are derived from natural resources or made from them in a production step.
 */
interface Material extends Commodity
{
	public const UNTRAINED_REGAIN = 0.2;

	/**
	 * Get the needed craft to create this artifact.
	 */
	public function getCraft(): Requirement;

	/**
	 * Get the resource to create this material.
	 */
	public function getResource(): Commodity;

	/**
	 * Get the number of items from one resource.
	 */
	public function getYield(): int;

	/**
	 * Get the recycling factor for regaining material when destroying.
	 */
	public function getRegain(): float;
}
