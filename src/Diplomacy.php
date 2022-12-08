<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\CountableTrait;
use Lemuria\Id;
use Lemuria\IteratorTrait;
use Lemuria\Model\Fantasya\Exception\UnknownPartyException;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

/**
 * A party's diplomacy consists of relations to other parties.
 *
 * There are three kinds of relations:
 *
 * 1. Acquaintances
 * When a unit meets another unit in the game, the other unit's party becomes an acquaintance.
 * 2. Relations
 * A party can have specific relations to its acquaintances.
 * 3. Contacts
 * These are special relations to a single unit that last until the end of a game round.
 *
 * @\ArrayAccess<Relation|string, Relation>
 * @\Iterator<string, Relation>
 */
final class Diplomacy implements \ArrayAccess, \Countable, \Iterator, Serializable
{
	use CountableTrait;
	use IteratorTrait;
	use SerializableTrait;

	private const ACQUAINTANCES = 'acquaintances';

	private const RELATIONS = 'relations';

	private const PARTY = 'party';

	private const REGION = 'region';

	private const AGREEMENT = 'agreement';

	/**
	 * @var Acquaintances
	 */
	private readonly Acquaintances $acquaintances;

	/**
	 * @var array<string, Relation>
	 */
	private array $relations = [];

	/**
	 * @var array<int, Unit>
	 */
	private array $contacts = [];

	/**
	 * @var array<int, string>
	 */
	private array $indices = [];

	/**
	 * Create the diplomacy of given party.
	 */

	public function __construct(private readonly Party $party) {
		$this->acquaintances = new Acquaintances();
	}


	public function Party(): Party {
		return $this->party;
	}


	public function Acquaintances(): Acquaintances {
		return $this->acquaintances;
	}

	/**
	 * Check if a relation is set.
	 *
	 * @param Relation|string $relation
	 * @noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function offsetExists(mixed $relation): bool {
		$id = $this->getId($relation);
		return isset($this->relations[$id]);
	}

	/**
	 * Get a relation.
	 *
	 * @param Relation|string $relation
	 * @throws \InvalidArgumentException
	 * @noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function offsetGet(mixed $relation): ?Relation {
		$id = $this->getId($relation);
		return $this->relations[$id] ?? null;
	}

	/**
	 * Set a relation.
	 *
	 * @param Relation|string $offset
	 * @param Relation $value
	 */
	public function offsetSet(mixed $offset, mixed $value): void {
		$this->add($value);
	}

	/**
	 * Remove a relation.
	 *
	 * @param Relation|string $relation
	 * @noinspection PhpParameterNameChangedDuringInheritanceInspection
	 */
	public function offsetUnset(mixed $relation): void {
		$id = $this->getId($relation);
		if (isset($this->relations[$id])) {
			unset($this->relations[$id]);
		}
	}

	public function current(): ?Relation {
		$id = $this->key();
		return $id ? $this->relations[$id] : null;
	}

		public function key(): ?string {
		if ($this->valid()) {
			return $this->indices[$this->index];
		}
		return null;
	}

	/**
	 * Get a plain data array of the model's data.
	 */
	public function serialize(): array {
		$relations = [];
		foreach ($this->relations as $relation) {
			$relations[] = [
				self::PARTY     => $relation->Party()->Id()->Id(),
				self::REGION    => $relation->Region()?->Id()->Id(),
				self::AGREEMENT => $relation->Agreement()
			];
		}
		return [self::ACQUAINTANCES => $this->acquaintances->serialize(), self::RELATIONS => $relations];
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->acquaintances->unserialize($data[self::ACQUAINTANCES]);

		if ($this->count > 0) {
			$this->clear();
		}
		foreach ($data[self::RELATIONS] as $row) {
			$this->validateSerializedRelation($row);
			$partyId   = $row[self::PARTY];
			$party     = Party::get(new Id($partyId));
			$regionId  = $row[self::REGION];
			$region    = $regionId ? Region::get(new Id($regionId)) : null;
			$agreement = $row[self::AGREEMENT];
			$relation  = new Relation($party, $region);
			$this->add($relation->set($agreement));
		}

		return $this;
	}

	/**
	 * Check if given party is an acquaintance.
	 */
	public function isKnown(Party $party): bool {
		return $this->acquaintances->has($party->Id());
	}

	/**
	 * Add a known party.
	 */
	public function knows(Party $party): Diplomacy {
		if ($party !== $this->party) {
			$this->acquaintances->add($party);
		}
		return $this;
	}

	/**
	 * Check if there is a specific agreement with a unit or the party of a unit.
	 */
	public function has(int $agreement, Party|Unit $partner, Region $region = null): bool {
		if ($partner instanceof Unit) {
			if ($this->hasContact($partner, $agreement)) {
				return true;
			}
			$party = $partner->Disguise();
			if (!($party instanceof Party) || $party === $this->party) {
				$party = $partner->Party();
			}
			if (!$region) {
				$region = $partner->Region();
			}
		} else {
			$party = $partner;
		}

		// Check relations for party.
		$relation = $this->offsetGet(new Relation($party, $region));
		if ($relation?->has($agreement)) {
			return true;
		}
		if ($region) {
			$relation = $this->offsetGet(new Relation($party));
			if ($relation?->has($agreement)) {
				return true;
			}
		}

		// Check general relations.
		$relation = $this->offsetGet(new Relation($this->party, $region));
		if ($relation?->has($agreement)) {
			return true;
		}
		if ($region) {
			$relation = $this->offsetGet(new Relation($this->party));
			if ($relation?->has($agreement)) {
				return true;
			}
		}

		// No relations found.
		return $agreement === Relation::NONE;
	}

	/**
	 * Get all relations to a specific Party.
	 *
	 * @return Relation[]
	 */
	public function search(Party $party): array {
		$id        = $party->Id() . '-';
		$relations = [];
		foreach ($this->relations as $key => $relation) {
			if (str_starts_with($key, $id)) {
				$relations[$key] = $relation;
			}
		}
		ksort($relations);
		return array_values($relations);
	}

	/**
	 * Add a relation.
	 *
	 * If a relation for the same party and region exists, it will be replaced.
	 */
	public function add(Relation $relation): Diplomacy {
		$party = $relation->Party();
		if ($party !== $this->party && !$this->isKnown($party)) {
			throw new UnknownPartyException($this, $relation->Party());
		}

		$id = (string)$relation;
		if (isset($this->relations[$id])) {
			$oldRelation = $this->relations[$id];
			$oldRelation->set($relation->Agreement());
		} else {
			$this->relations[$id] = $relation;
			$this->indices[]      = $id;
			$this->count++;
		}
		return $this;
	}

	/**
	 * Remove a relation.
	 */
	public function remove(Relation $relation): Diplomacy {
		$id = (string)$relation;
		if (isset($this->relations[$id])) {
			unset($this->relations[$id]);
			$this->indices = array_keys($this->relations);
			$this->count--;
		}
		return $this;
	}

	/**
	 * Clear all relations.
	 */
	public function clear(): Diplomacy {
		$this->relations = [];
		$this->indices   = [];
		$this->count     = 0;
		$this->index     = 0;
		return $this;
	}

	/**
	 * Add a temporary contact relation to a unit.
	 */
	public function contact(Unit $unit): Diplomacy {
		$this->contacts[$unit->Id()->Id()] = $unit;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::ACQUAINTANCES, Validate::Array);
		$this->validate($data, self::RELATIONS, Validate::Array);
	}

	/**
	 * Check that serialized relation is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedRelation(array $data): void {
		$this->validate($data, self::PARTY, Validate::Int);
		$this->validate($data, self::REGION, Validate::IntOrNull);
		$this->validate($data, self::AGREEMENT, Validate::Int);
	}

	/**
	 * Check if there is contact to a unit, optionally for a specific agreement.
	 */

	protected function hasContact(Unit $unit, int $agreement): bool {
		if (isset($this->contacts[$unit->Id()->Id()])) {
			return $agreement >= Relation::NONE && $agreement <= Relation::DISGUISE;
		}
		return false;
	}

	/**
	 * Get a relation ID.
	 *
	 * @throws \InvalidArgumentException
	 */
	private function getId($relation): string {
		if ($relation instanceof Relation) {
			return (string)$relation;
		}
		if (is_string($relation)) {
			return $relation;
		}
		throw new \InvalidArgumentException('Invalid relation ID: ' . $relation);
	}
}
