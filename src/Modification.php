<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use function Lemuria\sign;
use Lemuria\Exception\LemuriaException;

/**
 * A modification describe a talent bonus or malus.
 */
class Modification extends Ability
{
	private int $sign;

	/**
	 * Create a modification.
	 *
	 * @param Talent $talent
	 * @param int $modification
	 */
	public function __construct(Talent $talent, int $modification) {
		$this->sign = sign($modification);
		$experience = Ability::getExperience(abs($modification));
		parent::__construct($talent, $experience);
	}

	/**
	 * Get the experience.
	 *
	 * @return int
	 */
	public function Experience(): int {
		$experience = parent::Experience();
		return $this->sign * $experience;
	}

	/**
	 * Return the number of bonus or malus levels.
	 *
	 * @return int
	 */
	public function Level(): int {
		$level = parent::Level();
		return $this->sign * $level;
	}

	/**
	 * Return the modified ability.
	 *
	 * @param Ability $ability
	 * @return Ability
	 */
	public function getModified(Ability $ability): Ability {
		if ($ability->Talent() !== $this->Talent()) {
			throw new LemuriaException('Talent mismatch.');
		}
		$level = $ability->Level() + $this->Level();
		return new Ability($this->Talent(), Ability::getExperience($level));
	}
}
