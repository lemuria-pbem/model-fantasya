<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;

trait RawMaterialTrait
{
	use BuilderTrait;

	private ?Talent $talent = null;

	/**
	 * Get the required Talent to produce this raw material.
	 */
	public function getTalent(): Talent {
		if (!$this->talent) {
			$this->talent = self::createTalent($this->requirement);
		}
		return $this->talent;
	}
}
