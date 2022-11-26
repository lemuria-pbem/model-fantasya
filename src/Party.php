<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

use function Lemuria\getClass;
use Lemuria\Assignable;
use Lemuria\Collector;
use Lemuria\CollectorTrait;
use Lemuria\Engine\Newcomer;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Party\Presettings;
use Lemuria\Model\Fantasya\Party\Type;
use Lemuria\Serializable;

/**
 * A party is the representation of a Lemuria player.
 */
class Party extends Entity implements Assignable, Collector
{
	use BuilderTrait;
	use CollectorTrait;

	private string $banner;

	private Id $origin;

	private Race $race;

	private readonly People $people;

	private readonly Chronicle $chronicle;

	private readonly Diplomacy $diplomacy;

	private readonly HerbalBook $herbalBook;

	private readonly SpellBook $spellBook;

	private readonly Loot $loot;

	private readonly Presettings $presettings;

	private ?array $serializedDiplomacy = null;

	private ?array $serializedHerbalBook = null;

	private ?array $serializedSpellBook = null;

	private ?array $serializedLoot = null;

	private UuidInterface $uuid;

	private int $creation;

	private int $round;

	private ?int $retirement = null;

	/**
	 * Get a Party.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Party $party */
		$party = Lemuria::Catalog()->get($id, Domain::PARTY);
		return $party;
	}

	/**
	 * Create an empty party.
	 */
	public function __construct(?Newcomer $newcomer = null, private Type $type = Type::PLAYER) {
		$this->banner      = '';
		$this->uuid        = $newcomer ? Uuid::fromString($newcomer->Uuid()) : Uuid::uuid4();
		$this->creation    = $newcomer?->Creation() ?? time();
		$this->round       = Lemuria::Calendar()->Round();
		$this->people      = new People($this);
		$this->chronicle   = new Chronicle();
		$this->diplomacy   = new Diplomacy($this);
		$this->herbalBook  = new HerbalBook();
		$this->spellBook   = new SpellBook();
		$this->loot        = new Loot();
		$this->presettings = new Presettings();
	}

	/**
	 * Get the catalog domain.
	 */
	public function Catalog(): Domain {
		return Domain::PARTY;
	}

	public function Type(): Type {
		return $this->type;
	}

	public function Banner(): string {
		return $this->banner;
	}

	public function Uuid(): string {
		return $this->uuid->toString();
	}

	public function Creation(): int {
		return $this->creation;
	}

	public function Round(): int {
		return $this->round;
	}

	public function Retirement(): ?int {
		return $this->retirement;
	}

	/**
	 * Get the region in Lemuria where the party came into play.
	 */
	public function Origin(): Region {
		return Region::get($this->origin);
	}

	/**
	 * Get the party's race.
	 */
	public function Race(): Race {
		return $this->race;
	}

	/**
	 * Get all units.
	 */
	public function People(): People {
		return $this->people;
	}

	/**
	 * Get the chronicle.
	 */

	public function Chronicle(): Chronicle {
		return $this->chronicle;
	}

	/**
	 * Get all diplomatic relations.
	 */
	public function Diplomacy(): Diplomacy {
		if (is_array($this->serializedDiplomacy)) {
			$this->diplomacy->clear()->unserialize($this->serializedDiplomacy);
			$this->serializedDiplomacy = null;
		}
		return $this->diplomacy;
	}

	public function HerbalBook(): HerbalBook {
		if (is_array($this->serializedHerbalBook)) {
			$this->herbalBook->clear()->unserialize($this->serializedHerbalBook);
			$this->serializedHerbalBook = null;
		}
		return $this->herbalBook;
	}

	public function SpellBook(): SpellBook {
		if (is_array($this->serializedSpellBook)) {
			$this->spellBook->clear()->unserialize($this->serializedSpellBook);
			$this->serializedSpellBook = null;
		}
		return $this->spellBook;
	}

	public function Loot(): Loot {
		if (is_array($this->serializedLoot)) {
			$this->loot->unserialize($this->serializedLoot);
			$this->serializedLoot = null;
		}
		return $this->loot;
	}

	public function Presettings(): Presettings {
		return $this->presettings;
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data                = parent::serialize();
		$data['type']        = $this->type;
		$data['banner']      = $this->banner;
		$data['uuid']        = $this->Uuid();
		$data['creation']    = $this->creation;
		$data['round']       = $this->round;
		$data['retirement']  = $this->retirement;
		$data['origin']      = $this->origin->Id();
		$data['race']        = getClass($this->Race());
		$data['diplomacy']   = $this->Diplomacy()->serialize();
		$data['people']      = $this->People()->serialize();
		$data['chronicle']   = $this->Chronicle()->serialize();
		$data['herbalBook']  = $this->HerbalBook()->serialize();
		$data['spellBook']   = $this->SpellBook()->serialize();
		$data['loot']        = $this->Loot()->serialize();
		$data['presettings'] = $this->Presettings()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->type       = Type::from($data['type']);
		$this->banner     = $data['banner'];
		$this->uuid       = Uuid::fromString($data['uuid']);
		$this->creation   = $data['creation'];
		$this->round      = $data['round'];
		$this->retirement = $data['retirement'];
		$this->origin     = new Id($data['origin']);
		$this->setRace(self::createRace($data['race']));
		$this->People()->unserialize($data['people']);
		$this->Chronicle()->unserialize($data['chronicle']);
		$this->Presettings()->unserialize($data['presettings']);
		$this->serializedDiplomacy  = $data['diplomacy'];
		$this->serializedHerbalBook = $data['herbalBook'];
		$this->serializedSpellBook  = $data['spellBook'];
		$this->serializedLoot       = $data['loot'];
		return $this;
	}

	/**
	 * This method will be called by the Catalog after loading is finished; the Collector can initialize its collections
	 * then.
	 */
	public function collectAll(): Collector {
		$this->People()->addCollectorsToAll();
		return $this;
	}

	public function hasRetired(): bool {
		return $this->retirement !== null;
	}

	public function setBanner(string $banner): Party {
		$this->banner = $banner;
		return $this;
	}

	public function setOrigin(Region $origin): Party {
		$this->origin = $origin->Id();
		return $this;
	}

	public function setRace(Race $race): Party {
		$this->race = $race;
		return $this;
	}

	public function retire(): Party {
		if ($this->People()->count() > 0) {
			throw new LemuriaException('A party that has units cannot be retired.');
		}
		$this->retirement = Lemuria::Calendar()->Round();
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array &$data): void {
		parent::validateSerializedData($data);
		$this->validate($data, 'type', 'int');
		$this->validate($data, 'banner', 'string');
		$this->validate($data, 'uuid', 'string');
		$this->validate($data, 'creation', 'int');
		$this->validate($data, 'round', 'int');
		$this->validate($data, 'retirement', '?int');
		$this->validate($data, 'origin', 'int');
		$this->validate($data, 'race', 'string');
		$this->validate($data, 'people', 'array');
		$this->validate($data, 'diplomacy', 'array');
		$this->validate($data, 'chronicle', 'array');
		$this->validate($data, 'herbalBook', 'array');
		$this->validate($data, 'spellBook', 'array');
		$this->validate($data, 'loot', 'array');
		$this->validate($data, 'presettings', 'array');
	}
}
