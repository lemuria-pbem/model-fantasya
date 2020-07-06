<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Knowledge;
use Lemuria\Model\Lemuria\Modification;
use Lemuria\Model\Lemuria\Race;
use Lemuria\SingletonTrait;

/**
 * Base class for all races.
 */
abstract class AbstractRace implements Race
{
	use BuilderTrait;
	use SingletonTrait;

	private const SPEED = 1;

	private Knowledge $modifications;

	/**
	 * Get the speed when transporting.
	 *
	 * @return int
	 */
	public function Speed(): int {
		return self::SPEED;
	}

	/**
	 * Get the bonuses and maluses of talents.
	 *
	 * @return Knowledge
	 */
	public function Modifications(): Knowledge {
		if (!$this->modifications) {
			$this->modifications = new Knowledge();
			foreach ($this->mods() as $class => $mod) {
				$talent = self::createTalent($class);
				$this->modifications->add(new Modification($talent, $mod));
			}
		}
		return $this->modifications;
	}

	/**
	 * Get the modifications.
	 *
	 * @return array(string=>int)
	 */
	abstract protected function mods(): array;
}
