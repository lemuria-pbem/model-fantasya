<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Factory;

use JetBrains\PhpStorm\Pure;

use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Exception\DuplicateIdException;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Construction;
use Lemuria\Model\Lemuria\Party;
use Lemuria\Model\Lemuria\Region;
use Lemuria\Model\Lemuria\Unit;
use Lemuria\Model\Lemuria\Vessel;
use Lemuria\Model\Reassignment;

/**
 * The catalog registers all entities and is used to ensure that IDs are only used once per namespace.
 */
class LemuriaCatalog implements Catalog
{
	/**
	 * @var array(int=>array)
	 */
	private array $catalog = [];

	/**
	 * @var Reassignment[]
	 */
	private array $reassignments = [];

	/**
	 * @var array(int=>int)
	 */
	private array $nextId = [];

	private bool $isLoaded = false;

	public function __construct() {
		$reflection = new \ReflectionClass(Catalog::class);
		foreach ($reflection->getConstants() as $namespace) {
			if (!is_int($namespace)) {
				throw new LemuriaException('Expected integer catalog namespace.');
			}
			$this->catalog[$namespace] = [];
			$this->nextId[$namespace]  = 1;
		}
	}

	/**
	 * Checks if an entity exists in the specified catalog namespace.
	 */
	public function has(Id $id, int $namespace): bool {
		$this->checkNamespace($namespace);
		return isset($this->catalog[$namespace][$id->Id()]);
	}

	/**
	 * Check if game data has been loaded.
	 */
	#[Pure] public function isLoaded(): bool {
		return $this->isLoaded;
	}

	/**
	 * Get the specified entity.
	 *
	 * @throws NotRegisteredException
	 */
	public function get(Id $id, int $namespace): Identifiable {
		$this->checkNamespace($namespace);
		if (!isset($this->catalog[$namespace][$id->Id()])) {
			throw new NotRegisteredException($id);
		}

		return $this->catalog[$namespace][$id->Id()];
	}

	/**
	 * Get all entities of a namespace.
	 */
	public function getAll(int $namespace): array {
		$this->checkNamespace($namespace);
		return $this->catalog[$namespace];
	}

	/**
	 * Load game data into catalog.
	 */
	public function load(): Catalog {
		if (!$this->isLoaded) {
			foreach (Lemuria::Game()->getParties() as $data) {
				$party = new Party();
				$party->unserialize($data);
			}
			foreach (Lemuria::Game()->getUnits() as $data) {
				$unit = new Unit();
				$unit->unserialize($data);
			}
			foreach (Lemuria::Game()->getRegions() as $data) {
				$region = new Region();
				$region->unserialize($data);
			}
			foreach (Lemuria::Game()->getConstructions() as $data) {
				$construction = new Construction();
				$construction->unserialize($data);
			}
			foreach (Lemuria::Game()->getVessels() as $data) {
				$vessel = new Vessel();
				$vessel->unserialize($data);
			}
			$this->isLoaded = true;

			$this->callCollectAll();
		}
		return $this;
	}

	/**
	 * Save game data from catalog.
	 */
	public function save(): Catalog {
		$entities = [];
		foreach ($this->catalog[Catalog::PARTIES] as $id => $party/* @var Party $party */) {
			$entities[$id] = $party->serialize();
		}
		Lemuria::Game()->setParties($entities);
		$entities = [];
		foreach ($this->catalog[Catalog::UNITS] as $id => $unit/* @var Unit $unit */) {
			$entities[$id] = $unit->serialize();
		}
		Lemuria::Game()->setUnits($entities);
		$entities = [];
		foreach ($this->catalog[Catalog::LOCATIONS] as $id => $region/* @var Region $region */) {
			$entities[$id] = $region->serialize();
		}
		Lemuria::Game()->setRegions($entities);
		$entities = [];
		foreach ($this->catalog[Catalog::CONSTRUCTIONS] as $id => $construction/* @var Construction $construction */) {
			$entities[$id] = $construction->serialize();
		}
		Lemuria::Game()->setConstructions($entities);
		$entities = [];
		foreach ($this->catalog[Catalog::VESSELS] as $id => $vessel/* @var Vessel $vessel */) {
			$entities[$id] = $vessel->serialize();
		}
		Lemuria::Game()->setVessels($entities);
		return $this;
	}

	/**
	 * Register an entity.
	 *
	 * @throws DuplicateIdException
	 */
	public function register(Identifiable $identifiable): Catalog {
		$namespace = $identifiable->Catalog();
		$this->checkNamespace($namespace);
		$id = $identifiable->Id()->Id();
		if (isset($this->catalog[$namespace][$id])) {
			throw new DuplicateIdException($identifiable);
		}

		$this->catalog[$namespace][$id] = $identifiable;
		if ($this->nextId[$namespace] === $id) {
			$this->searchNextId($namespace);
		}
		return $this;
	}

	/**
	 * Remove an entity.
	 *
	 * @throws NotRegisteredException
	 */
	public function remove(Identifiable $identifiable): Catalog {
		$namespace = $identifiable->Catalog();
		$this->checkNamespace($namespace);
		$id = $identifiable->Id()->Id();
		if (!isset($this->catalog[$namespace][$id])) {
			throw new NotRegisteredException($identifiable->Id());
		}

		unset($this->catalog[$namespace][$id]);
		return $this;
	}

	/**
	 * Propagate change of an entity's ID.
	 *
	 * If old ID is null, propagate removal instead of reassignment.
	 */
	public function reassign(Identifiable $identifiable, ?Id $oldId = null): Catalog {
		foreach ($this->reassignments as $reassignment) {
			$oldId ? $reassignment->reassign($oldId, $identifiable) : $reassignment->remove($identifiable);
		}
		return $this;
	}

	/**
	 * Reserve the next ID that is available for a namespace.
	 */
	public function nextId(int $namespace): Id {
		$id = new Id($this->nextId[$namespace]);
		$this->searchNextId($namespace);
		return $id;
	}

	/**
	 * Register a reassignment listener.
	 */
	public function addReassignment(Reassignment $listener): Catalog {
		$this->reassignments[] = $listener;
		return $this;
	}

	/**
	 * Check if namespace is valid.
	 *
	 * @throws LemuriaException
	 */
	private function checkNamespace(int $namespace): void {
		if (!isset($this->catalog[$namespace])) {
			$bug = 'Namespace ' . $namespace . ' is not a valid catalog namespace.';
			throw new LemuriaException($bug, new \InvalidArgumentException());
		}
	}

	/**
	 * Search for next available ID of given namespace.
	 */
	private function searchNextId(int $namespace): void {
		$id = $this->nextId[$namespace];
		do {
			$id++;
		} while (isset($this->catalog[$namespace][$id]));
		$this->nextId[$namespace] = $id;
	}

	/**
	 * Calls collectAll() on all collectors in the Catalog.
	 */
	private function callCollectAll(): void {
		foreach ($this->catalog[Catalog::PARTIES] as $party/* @var Party $party */) {
			$party->collectAll();
		}
		foreach ($this->catalog[Catalog::LOCATIONS] as $region/* @var Region $region */) {
			$region->collectAll();
		}
		foreach ($this->catalog[Catalog::CONSTRUCTIONS] as $construction/* @var Construction $construction */) {
			$construction->collectAll();
		}
		foreach ($this->catalog[Catalog::VESSELS] as $vessel/* @var Vessel $vessel */) {
			$vessel->collectAll();
		}
	}
}
