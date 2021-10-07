<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\LemuriaException;

/**
 * A modification describes a talent bonus or malus.
 */
class DoubleAbility extends Modification
{
	public function __construct(Talent $talent) {
		parent::__construct($talent, 0);
	}

	/**
	 * Return the modified ability.
	 */
	public function getModified(Ability $ability): Ability {
		if ($ability->Talent() !== $this->Talent()) {
			throw new LemuriaException('Talent mismatch.');
		}
		$level = max(0, $ability->Level());
		return new Ability($this->Talent(), Ability::getExperience($level));
	}
}
