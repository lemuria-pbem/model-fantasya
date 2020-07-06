<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Item;
use Lemuria\Model\Exception\ModelException;

/**
 * An ability of a unit describes the experience in a talent.
 */
class Ability extends Item
{
	/**
	 * Calculate experience from talent level.
	 *
	 * @param int $level
	 * @return int
	 * @throws ModelException Level is a negative value.
	 */
	public static function getExperience(int $level): int {
		if ($level < 0) {
			throw new ModelException('Level must be a positive value.');
		}
		return 100 * $level ** 2;
	}

	/**
	 * Calculate level from experience points.
	 *
	 * @param int $experience
	 * @return int
	 * @throws ModelException Experience points is a negative value.
	 */
	public static function getLevel(int $experience): int {
		if ($experience < 0) {
			throw new ModelException('Experience must be a positive value.');
		}
		return (int)floor(sqrt($experience / 100));
	}

	/**
	 * Create an ability.
	 *
	 * @param Talent $talent
	 * @param int $experience
	 */
	public function __construct(Talent $talent, int $experience) {
		parent::__construct($talent, $experience);
	}

	/**
	 * Get the experience.
	 *
	 * @return int
	 */
	public function Experience(): int {
		return $this->Count();
	}

	/**
	 * Get the level of experience.
	 *
	 * @return int
	 */
	public function Level(): int {
		return self::getLevel($this->Count());
	}

	/**
	 * Get the talent.
	 *
	 * @return Talent
	 */
	public function Talent(): Talent {
		$talent = $this->getObject(); /* @var Talent $talent */
		return $talent;
	}
}
