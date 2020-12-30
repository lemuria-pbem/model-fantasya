<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Building;
use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Constructing;

/**
 * Base class for any building.
 */
abstract class AbstractBuilding implements Building
{
	use ArtifactTrait;
	use BuilderTrait;

	private Requirement $craft;

	/**
	 * Get the needed craft to create this artifact.
	 */
	public function getCraft(): Requirement {
		if (!$this->craft) {
			$talent      = self::createTalent(Constructing::class);
			$this->craft = new Requirement($talent, $this->constructionLevel());
		}
		return $this->craft;
	}

	/**
	 * Get the minimum skill in Construction to build this building.
	 */
	#[Pure] abstract protected function constructionLevel(): int;
}
