<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Model\Lemuria\Factory\BuilderTrait;

trait RawMaterialTrait
{
	use BuilderTrait;

	private ?Talent $talent = null;

	/**
	 * Get the required Talent to produce this raw material.
	 *
	 * @return Talent
	 */
	public function getTalent(): Talent {
		if (!$this->talent) {
			$this->talent = self::createTalent($this->requirement);
		}
		return $this->talent;
	}
}
