<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;

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
	 * @var array<int, Id>
	 */
	private array $identifierMap = [];

	public function unserialize(array $data): static {
		parent::unserialize($data);
		foreach ($data as $id) {
			$id    = new Id($id);
			$realm = Realm::get($id);
			$this->identifierMap[$realm->Identifier()->Id()] = $id;
		}
		return $this;
	}

	public function identify(Id $id): ?Id {
		$map = $id->Id();
		return $this->identifierMap[$map] ?? null;
	}

	public function getClone(): static {
		return clone $this;
	}

	public function add(Realm $realm): static {
		$this->addEntity($realm->Id());
		$this->identifierMap[$realm->Identifier()->Id()] = $realm->Id();
		if ($this->hasCollector()) {
			$realm->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Realm $realm): static {
		$this->removeEntity($realm->Id());
		unset($this->identifierMap[$realm->Identifier()->Id()]);
		if ($this->hasCollector()) {
			$realm->removeCollector($this->collector());
		}
		return $this;
	}

	protected function get(Id $id): Realm {
		return Realm::get($id);
	}
}
