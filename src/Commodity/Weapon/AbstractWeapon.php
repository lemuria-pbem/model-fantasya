<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Weapon;

/**
 * Base class for any weapon.
 */
abstract class AbstractWeapon implements Commodity, Weapon
{
	use ArtifactTrait;
	use BuilderTrait;

	/**
	 * Get the needed skill.
	 *
	 * @return Requirement
	 */
	public function getSkill(): Requirement {
		$talent = self::createTalent($this->talent());
		return new Requirement($talent, 1);
	}

	/**
	 * Get the skill talent.
	 *
	 * @return string
	 */
	abstract protected function talent(): string;
}
