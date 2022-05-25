<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use function Lemuria\sign;
use Lemuria\Exception\LemuriaException;

/**
 * A modification describes a talent bonus or malus.
 */
class Modification extends Ability
{
	private readonly int $sign;

	public function __construct(Talent $talent, int $modification) {
		$this->sign = sign($modification);
		$experience = Ability::getExperience(abs($modification));
		parent::__construct($talent, $experience);
	}

	public function Experience(): int {
		$experience = parent::Experience();
		return $this->sign * $experience;
	}

	/**
	 * Return the number of bonus or malus levels.
	 */
	public function Level(): int {
		$level = parent::Level();
		return $this->sign * $level;
	}

	/**
	 * Return the modified ability.
	 */
	public function getModified(Ability $ability): Ability {
		if ($ability->Talent() !== $this->Talent()) {
			throw new LemuriaException('Talent mismatch.');
		}
		$level = max(0, $ability->Level() + $this->Level());
		return new Ability($this->Talent(), Ability::getExperience($level));
	}
}
