<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Item;

/**
 * A gang is an item of some race.
 */
class Gang extends Item
{
	/**
	 * Create a quantity of some race.
	 */
	#[Pure] public function __construct(Race $race, int $count = 1) {
		parent::__construct($race, $count);
	}

	#[Pure] public function Race(): Race {
		/** @var Race $race */
		$race = $this->getObject();
		return $race;
	}

	/**
	 * Get the gangs' total weight.
	 */
	#[Pure] public function Weight(): int {
		return $this->Count() * $this->Race()->Weight();
	}

	public function add(Gang $gang): Gang {
		$this->addItem($gang);

		return $this;
	}

	public function remove(Gang $gang): Gang {
		$this->removeItem($gang);

		return $this;
	}
}