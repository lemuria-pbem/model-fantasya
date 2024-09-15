<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Catalog;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\DuplicateIdException;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Construction;
use Lemuria\Model\Fantasya\Continent;
use Lemuria\Model\Fantasya\Dispatcher\Event\Catalog\Loaded;
use Lemuria\Model\Fantasya\Dispatcher\Event\Catalog\NextId;
use Lemuria\Model\Fantasya\Dispatcher\Event\Catalog\Saved;
use Lemuria\Model\Fantasya\Market\Trade;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Realm;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Scenario\Quest;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Model\Fantasya\Vessel;
use Lemuria\Model\Reassignment;
use Lemuria\Version\VersionFinder;
use Lemuria\Version\VersionTag;

class LemuriaCatalog implements Catalog
{
	private const int INITIAL_ID = 1;

	/**
	 * @var array<int, array>
	 */
	private array $catalog = [];

	/**
	 * @var array<Reassignment>
	 */
	private array $reassignments = [];

	/**
	 * @var array<int, int>
	 */
	private array $nextId = [];

	private bool $isLoaded = false;

	public function __construct() {
		$dispatcher = Lemuria::Dispatcher();
		foreach (Domain::cases() as $domain) {
			$this->catalog[$domain->value] = [];
			$this->nextId[$domain->value]  = self::INITIAL_ID;
			$dispatcher->dispatch(new NextId($domain->value, self::INITIAL_ID));
		}
	}

	public function has(Id $id, Domain $domain): bool {
		return isset($this->catalog[$domain->value][$id->Id()]);
	}

	public function isLoaded(): bool {
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

	public function load(): static {
		if (!$this->isLoaded) {
			foreach (Lemuria::Game()->getContinents() as $data) {
				$continent = new Continent();
				$continent->unserialize($data);
			}
			foreach (Lemuria::Game()->getRegions() as $data) {
				$region = new Region();
				$region->unserialize($data);
			}
			foreach (Lemuria::Game()->getRealms() as $data) {
				$realm = new Realm();
				$realm->unserialize($data);
			}
			foreach (Lemuria::Game()->getParties() as $data) {
				$party = new Party();
				$party->unserialize($data);
			}
			foreach (Lemuria::Game()->getUnits() as $data) {
				$unit = new Unit();
				$unit->unserialize($data);
			}
			foreach (Lemuria::Game()->getTrades() as $data) {
				$trade = new Trade(true);
				$trade->unserialize($data);
			}
			foreach (Lemuria::Game()->getQuests() as $data) {
				$quest = new Quest();
				$quest->unserialize($data);
			}
			foreach (Lemuria::Game()->getConstructions() as $data) {
				$construction = new Construction();
				$construction->unserialize($data);
			}
			foreach (Lemuria::Game()->getVessels() as $data) {
				$vessel = new Vessel();
				$vessel->unserialize($data);
			}
			foreach (Lemuria::Game()->getUnica() as $data) {
				$unicum = new Unicum();
				$unicum->unserialize($data);
			}
			$this->isLoaded = true;
			Lemuria::Dispatcher()->dispatch(new Loaded());
		}
		return $this;
	}

	public function save(): static {
		$entities = [];
		foreach ($this->catalog[Domain::Party->value] as $id => $party /* @var Party $party */) {
			$entities[$id] = $party->serialize();
		}
		Lemuria::Game()->setParties($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Unit->value] as $id => $unit /* @var Unit $unit */) {
			$entities[$id] = $unit->serialize();
		}
		Lemuria::Game()->setUnits($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Trade->value] as $id => $trade /* @var Trade $trade */) {
			$entities[$id] = $trade->serialize();
		}
		Lemuria::Game()->setTrades($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Quest->value] as $id => $quest /* @var Quest $quest */) {
			$entities[$id] = $quest->serialize();
		}
		Lemuria::Game()->setQuests($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Location->value] as $id => $region /* @var Region $region */) {
			$entities[$id] = $region->serialize();
		}
		Lemuria::Game()->setRegions($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Construction->value] as $id => $construction /* @var Construction $construction */) {
			$entities[$id] = $construction->serialize();
		}
		Lemuria::Game()->setConstructions($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Vessel->value] as $id => $vessel /* @var Vessel $vessel */) {
			$entities[$id] = $vessel->serialize();
		}
		Lemuria::Game()->setVessels($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Continent->value] as $id => $continent /* @var Continent $continent */) {
			$entities[$id] = $continent->serialize();
		}
		Lemuria::Game()->setContinents($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Realm->value] as $id => $realm /* @var Realm $realm */) {
			$entities[$id] = $realm->serialize();
		}
		Lemuria::Game()->setRealms($entities);
		$entities = [];
		foreach ($this->catalog[Domain::Unicum->value] as $id => $unicum /* @var Unicum $unicum */) {
			$entities[$id] = $unicum->serialize();
		}
		Lemuria::Game()->setUnica($entities);
		Lemuria::Dispatcher()->dispatch(new Saved());
		return $this;
	}

	/**
	 * @throws DuplicateIdException
	 */
	public function register(Identifiable $identifiable): static {
		$domain = $identifiable->Catalog()->value;
		$id     = $identifiable->Id()->Id();
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
	public function remove(Identifiable $identifiable): static {
		$domain = $identifiable->Catalog()->value;
		$id     = $identifiable->Id()->Id();
		if (!isset($this->catalog[$domain][$id])) {
			throw new NotRegisteredException($identifiable->Id());
		}

		unset($this->catalog[$domain][$id]);
		return $this;
	}

	public function reassign(Identifiable $identifiable, ?Id $oldId = null): static {
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

	public function addReassignment(Reassignment $listener): static {
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
		Lemuria::Dispatcher()->dispatch(new NextId($domain, $id));
	}
}
