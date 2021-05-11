<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Factory\BuilderTrait;

trait RawMaterialTrait
{
	use BuilderTrait;

	private ?Requirement $requirement = null;

	protected string $craft;

	/**
	 * Get the required Talent to produce this raw material.
	 */
	public function getCraft(): Requirement {
		if (!$this->requirement) {
			$this->requirement = new Requirement(self::createTalent($this->craft), $this->getCraftLevel());
		}
		return $this->requirement;
	}

	protected function getCraftLevel(): int {
		return 1;
	}
}
