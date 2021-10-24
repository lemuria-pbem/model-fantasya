<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Artifact;
use Lemuria\Model\Fantasya\ArtifactTrait;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Protection;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Armory;

/**
 * Base class for any Protection.
 */
abstract class AbstractProtection implements Artifact, Commodity, Protection
{
	use ArtifactTrait;
	use BuilderTrait;

	protected Requirement $craft;

	public function __construct() {
		$this->craft = new Requirement(self::createTalent(Armory::class), $this->craft());
	}

	public function getCraft(): Requirement {
		return $this->craft;
	}

	#[Pure] abstract protected function craft(): int;
}
