<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use JetBrains\PhpStorm\Pure;

use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\DuplicateIdException;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Construction;
use Lemuria\Model\Fantasya\Continent;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Model\Fantasya\Vessel;
use Lemuria\Model\Reassignment;
use Lemuria\Version\VersionFinder;
use Lemuria\Version\VersionTag;

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
		foreach (Domain::cases() as $domain) {
			$this->catalog[$domain->value] = [];
			$this->nextId[$domain->value]  = 1;
		}
	}

	#[Pure] public function has(Id $id, Domain $domain): bool {
		return isset($this->catalog[$domain->value][$id->Id()]);
	}

	#[Pure] public function isLoaded(): bool {
		return $this->isLoaded;
	}

	public function get(Id $id, Domain $domain): Identifiable {
		if (!isset($this->catalog[$domain->value][$id->Id()])) {
			throw new NotRegisteredException($id);
		}

		return $this->catalog[$domain->value][$id->Id()];
	}

	public function getAll(Domain $domain): array {
		return $this->catalog[$domain->value];
	}

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
			foreach (Lemuria::Game()->getContinents() as $data) {
				$continent = new Continent();
				$continent->unserialize($data);
			}
			foreach (Lemuria::Game()->getUnica() as $data) {
				$unicum = new Unicum();
				$unicum->unserialize($data);
			}
			$this->isLoaded = true;

			$this->callCollectAll();
		}
		return $this;
	}

	public function save(): Catalog {
		$entities = [];
		foreach ($this->catalog[Domain::PARTY->value] as $id => $party /* @var Party $party */) {
			$entities[$id] = $party->serialize();
		}
		Lemuria::Game()->setParties($entities);
		$entities = [];
		foreach ($this->catalog[Domain::UNIT->value] as $id => $unit /* @var Unit $unit */) {
			$entities[$id] = $unit->serialize();
		}
		Lemuria::Game()->setUnits($entities);
		$entities = [];
		foreach ($this->catalog[Domain::LOCATION->value] as $id => $region /* @var Region $region */) {
			$entities[$id] = $region->serialize();
		}
		Lemuria::Game()->setRegions($entities);
		$entities = [];
		foreach ($this->catalog[Domain::CONSTRUCTION->value] as $id => $construction /* @var Construction $construction */) {
			$entities[$id] = $construction->serialize();
		}
		Lemuria::Game()->setConstructions($entities);
		$entities = [];
		foreach ($this->catalog[Domain::VESSEL->value] as $id => $vessel /* @var Vessel $vessel */) {
			$entities[$id] = $vessel->serialize();
		}
		Lemuria::Game()->setVessels($entities);
		$entities = [];
		foreach ($this->catalog[Domain::CONTINENT->value] as $id => $continent /* @var Continent $continent */) {
			$entities[$id] = $continent->serialize();
		}
		Lemuria::Game()->setContinents($entities);
		$entities = [];
		foreach ($this->catalog[Domain::UNICUM->value] as $id => $unicum /* @var Unicum $unicum */) {
			$entities[$id] = $unicum->serialize();
		}
		Lemuria::Game()->setUnica($entities);
		return $this;
	}

	/**
	 * @throws DuplicateIdException
	 */
	public function register(Identifiable $identifiable): Catalog {
		$domain = $identifiable->Catalog()->value;
		$id = $identifiable->Id()->Id();
		if (isset($this->catalog[$domain][$id])) {
			throw new DuplicateIdException($identifiable);
		}

		$this->catalog[$domain][$id] = $identifiable;
		if ($this->nextId[$domain] === $id) {
			$this->searchNextId($domain);
		}
		return $this;
	}

	/**
	 * @throws NotRegisteredException
	 */
	public function remove(Identifiable $identifiable): Catalog {
		$domain = $identifiable->Catalog()->value;
		$id = $identifiable->Id()->Id();
		if (!isset($this->catalog[$domain][$id])) {
			throw new NotRegisteredException($identifiable->Id());
		}

		unset($this->catalog[$domain][$id]);
		return $this;
	}

	public function reassign(Identifiable $identifiable, ?Id $oldId = null): Catalog {
		foreach ($this->reassignments as $reassignment) {
			$oldId ? $reassignment->reassign($oldId, $identifiable) : $reassignment->remove($identifiable);
		}
		return $this;
	}

	public function nextId(Domain $domain): Id {
		$id = new Id($this->nextId[$domain->value]);
		$this->searchNextId($domain->value);
		return $id;
	}

	public function addReassignment(Reassignment $listener): Catalog {
		$this->reassignments[] = $listener;
		return $this;
	}

	public function getVersion(): VersionTag {
		$versionFinder = new VersionFinder(__DIR__ . '/../..');
		return $versionFinder->get();
	}

	/**
	 * Search for next available ID of given domain.
	 */
	private function searchNextId(int $domain): void {
		$id = $this->nextId[$domain];
		do {
			$id++;
		} while (isset($this->catalog[$domain][$id]));
		$this->nextId[$domain] = $id;
	}

	/**
	 * Calls collectAll() on all collectors in the Catalog.
	 */
	private function callCollectAll(): void {
		foreach ($this->catalog[Domain::PARTY->value] as $party /* @var Party $party */) {
			$party->collectAll();
		}
		foreach ($this->catalog[Domain::LOCATION->value] as $region /* @var Region $region */) {
			$region->collectAll();
		}
		foreach ($this->catalog[Domain::CONSTRUCTION->value] as $construction /* @var Construction $construction */) {
			$construction->collectAll();
		}
		foreach ($this->catalog[Domain::VESSEL->value] as $vessel /* @var Vessel $vessel */) {
			$vessel->collectAll();
		}
		foreach ($this->catalog[Domain::CONTINENT->value] as $continent /* @var Continent $continent */) {
			$continent->collectAll();
		}
	}
}
