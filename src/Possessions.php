<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Serializable;

/**
 * The possessions of a party are its realms.
 *
 * @method Realm offsetGet(int|Id $offset)
 * @method Realm current()
 * @method Possessions getIterator()
 */
class Possessions extends EntitySet
{
	/**
	 * @var array<int, int>
	 */
	private array $identifierMap = [];

	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		foreach ($data as $id) {
			$realm = Realm::get(new Id($id));
			$this->identifierMap[$realm->Identifier()->Id()] = $id;
		}
		return $this;
	}

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