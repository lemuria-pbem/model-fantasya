<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

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
	 * @throws ModelException Experience points is a negative value.
	 */
	public static function getLevel(int $experience): int {
		if ($experience < 0) {
			throw new ModelException('Experience must be a positive value.');
		}
		return (int)floor(sqrt($experience / 100));
	}

	/**
	 * @noinspection PhpAttributeCanBeAddedToOverriddenMemberInspection
	 */
	#[Pure] public function __construct(Talent $talent, int $experience) {
		parent::__construct($talent, $experience);
	}

	#[Pure] public function Experience(): int {
		return $this->Count();
	}

	public function Level(): int {
		return self::getLevel($this->Count());
	}

	#[Pure] public function Talent(): Talent {
		/** @var Talent $talent */
		$talent = $this->getObject();
		return $talent;
	}
}
