<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;

trait RawMaterialTrait
{
	use BuilderTrait;

	private ?Requirement $requirement = null;

	private string $craft;

	private int $level = 1;

	/**
	 * Get the required Talent to produce this raw material.
	 */
	public function getCraft(): Requirement {
		if (!$this->requirement) {
			$this->requirement = new Requirement(self::createTalent($this->craft), $this->level);
		}
		return $this->requirement;
	}
}
