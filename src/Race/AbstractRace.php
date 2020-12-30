<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

use JetBrains\PhpStorm\Pure;

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

	private ?Knowledge $modifications;

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}

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

	#[Pure] abstract protected function mods(): array;
}
