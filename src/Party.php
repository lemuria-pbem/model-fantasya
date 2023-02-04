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
use Lemuria\Validate;

/**
 * A party is the representation of a Lemuria player.
 */
class Party extends Entity implements Assignable, Collector
{
	use BuilderTrait;
	use CollectorTrait;

	private const TYPE = 'type';

	private const BANNER = 'banner';

	private const UUID = 'uuid';

	private const CREATION = 'creation';

	private const ROUND = 'round';

	private const RETIREMENT = 'retirement';

	private const ORIGIN = 'origin';

	private const RACE = 'race';

	private const DIPLOMACY = 'diplomacy';

	private const PEOPLE = 'people';

	private const CHRONICLE = 'chronicle';

	private const HERBAL_BOOK = 'herbalBook';

	private const SPELL_BOOK = 'spellBook';

	private const LOOT = 'loot';

	private const PRESETTINGS = 'presettings';

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
	 * @return array<Party>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Party);
	}

	/**
	 * Get a Party.
	 *
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Party $party */
		$party = Lemuria::Catalog()->get($id, Domain::Party);
		return $party;
	}

	/**
	 * Create an empty party.
	 */
	public function __construct(?Newcomer $newcomer = null, private Type $type = Type::Player) {
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
		return Domain::Party;
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
		$data                     = parent::serialize();
		$data[self::TYPE]         = $this->type;
		$data[self::BANNER]       = $this->banner;
		$data[self::UUID]         = $this->Uuid();
		$data[self::CREATION]     = $this->creation;
		$data[self::ROUND]        = $this->round;
		$data[self::RETIREMENT]   = $this->retirement;
		$data[self::ORIGIN]       = $this->origin->Id();
		$data[self::RACE]         = getClass($this->Race());
		$data[self::DIPLOMACY]    = $this->Diplomacy()->serialize();
		$data[self::PEOPLE]       = $this->People()->serialize();
		$data[self::CHRONICLE]    = $this->Chronicle()->serialize();
		$data[self::HERBAL_BOOK]  = $this->HerbalBook()->serialize();
		$data[self::SPELL_BOOK]   = $this->SpellBook()->serialize();
		$data[self::LOOT]         = $this->Loot()->serialize();
		$data[self::PRESETTINGS]  = $this->Presettings()->serialize();
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 */
	public function unserialize(array $data): Serializable {
		parent::unserialize($data);
		$this->type       = Type::from($data[self::TYPE]);
		$this->banner     = $data[self::BANNER];
		$this->uuid       = Uuid::fromString($data[self::UUID]);
		$this->creation   = $data[self::CREATION];
		$this->round      = $data[self::ROUND];
		$this->retirement = $data[self::RETIREMENT];
		$this->origin     = new Id($data[self::ORIGIN]);
		$this->setRace(self::createRace($data[self::RACE]));
		$this->People()->unserialize($data[self::PEOPLE]);
		$this->Chronicle()->unserialize($data[self::CHRONICLE]);
		$this->Presettings()->unserialize($data[self::PRESETTINGS]);
		$this->serializedDiplomacy  = $data[self::DIPLOMACY];
		$this->serializedHerbalBook = $data[self::HERBAL_BOOK];
		$this->serializedSpellBook  = $data[self::SPELL_BOOK];
		$this->serializedLoot       = $data[self::LOOT];
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
	 * @noinspection DuplicatedCode
	 */
	protected function validateSerializedData(array $data): void {
		parent::validateSerializedData($data);
		$this->validate($data, self::TYPE, Validate::Int);
		$this->validate($data, self::BANNER, Validate::String);
		$this->validate($data, self::UUID, Validate::String);
		$this->validate($data, self::CREATION, Validate::Int);
		$this->validate($data, self::ROUND, Validate::Int);
		$this->validate($data, self::RETIREMENT, Validate::IntOrNull);
		$this->validate($data, self::ORIGIN, Validate::Int);
		$this->validate($data, self::RACE, Validate::String);
		$this->validate($data, self::PEOPLE, Validate::Array);
		$this->validate($data, self::DIPLOMACY, Validate::Array);
		$this->validate($data, self::CHRONICLE, Validate::Array);
		$this->validate($data, self::HERBAL_BOOK, Validate::Array);
		$this->validate($data, self::SPELL_BOOK, Validate::Array);
		$this->validate($data, self::LOOT, Validate::Array);
		$this->validate($data, self::PRESETTINGS, Validate::Array);
	}
}
