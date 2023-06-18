<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Model\Exception\NotRegisteredException;

/**
 * The possessions of a party are its realms.
 *
 * @method Realm offsetGet(int|Id $offset)
 * @method Realm current()
 * @method Possessions getIterator()
 */
class Possessions extends EntitySet
{
	private array $identifierMap = [];

	public function getClone(): Possessions {
		return clone $this;
	}

	public function add(Realm $realm): Possessions {
		$this->addEntity($realm->Identifier());
		$this->identifierMap[$realm->Identifier()->Id()] = $realm->Id()->Id();
		if ($this->hasCollector()) {
			$realm->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Realm $realm): Possessions {
		$this->removeEntity($realm->Identifier());
		unset($this->identifierMap[$realm->Identifier()->Id()]);
		if ($this->hasCollector()) {
			$realm->removeCollector($this->collector());
		}
		return $this;
	}

	protected function get(Id $id): Realm {
		$index = $id->Id();
		if (!isset($this->identifierMap[$index])) {
			throw new NotRegisteredException($id);
		}
		$id = new Id($this->identifierMap[$index]);
		return Realm::get($id);
	}
}
