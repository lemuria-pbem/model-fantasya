<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * A requirement is a minimum talent level definition.
 */
class Requirement extends Ability
{
	public function __construct(Talent $talent, int $level = 1) {
		$experience = Ability::getExperience($level);
		parent::__construct($talent, $experience);
	}
}
