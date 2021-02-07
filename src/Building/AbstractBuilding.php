<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\LemuriaException;
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

	private ?Requirement $craft = null;

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
	 * Get the best fitting building for given size of this building.
	 */
	#[Pure] public function correctBuilding(int $size): Building {
		$this->validateSize($size);
		return $this;
	}

	/**
	 * Get the best fitting size for given size of this building.
	 */
	#[Pure] public function correctSize(int $size): int {
		$this->validateSize($size);
		return $size;
	}

	/**
	 * Get the minimum skill in Construction to build this building.
	 */
	#[Pure] abstract protected function constructionLevel(): int;

	protected function validateSize(int $size): void {
		if ($size < 0) {
			throw new LemuriaException('Given size must be positive.');
		}
	}
}
