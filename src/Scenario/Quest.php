<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Scenario;

use function Lemuria\getClass;
use Lemuria\Collectible;
use Lemuria\CollectibleTrait;
use Lemuria\Exception\SingletonException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\IdentifiableTrait;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Scenario\Quest\Controller;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Model\Reassignment;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class Quest implements \Stringable, Collectible, Identifiable, Reassignment, Serializable
{
	private const string ID = 'id';

	private const string OWNER = 'owner';

	private const string CONTROLLER = 'controller';

	private const string PAYLOAD = 'payload';

	use BuilderTrait;
	use CollectibleTrait;
	use IdentifiableTrait;
	use SerializableTrait;

	private int $owner;

	private readonly Controller $controller;

	private Payload $payload;

	/**
	 * @return array<Quest>
	 */
	public static function all(): array {
		return Lemuria::Catalog()->getAll(Domain::Quest);
	}

	/**
	 * @throws NotRegisteredException
	 */
	public static function get(Id $id): self {
		/** @var Quest $quest */
		$quest = Lemuria::Catalog()->get($id, Domain::Quest);
		return $quest;
	}

	public function Catalog(): Domain {
		return Domain::Quest;
	}

	public function Owner(): Unit {
		return Unit::get(new Id($this->owner));
	}

	public function Controller(): Controller {
		return $this->controller;
	}

	public function Payload(): Payload {
		return $this->payload;
	}

	public function __toString(): string {
		return $this->controller . ' ' . $this->Id();
	}

	public function reassign(Id $oldId, Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Quest && $oldId->Id() === $this->owner) {
			$this->owner = $identifiable->Id()->Id();
		}
	}

	public function remove(Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Quest && $identifiable->Id()->Id() === $this->owner) {
			$this->owner = 0;
		}
	}

	public function serialize(): array {
		return [
			self::ID         => $this->Id()->Id(),
			self::OWNER      => $this->owner,
			self::CONTROLLER => getClass($this->controller),
			self::PAYLOAD    => $this->payload->serialize()
		];
	}

	public function unserialize(array $data): static {
		$this->validateSerializedData($data);
		$this->setId(new Id(($data[self::ID])));
		$this->owner = $data[self::OWNER];
		$controller  = Lemuria::Builder()->create($data[self::CONTROLLER]);
		if ($controller instanceof Controller) {
			$this->setController($controller);
			$this->payload->unserialize($data[self::PAYLOAD]);
		} else {
			throw new SingletonException('controller');
		}
		return $this;
	}

	public function setOwner(Unit $owner): static {
		$this->owner = $owner->Id()->Id();
		return $this;
	}

	public function setController(Controller $controller): static {
		$this->controller = $controller;
		$this->payload    = $controller->createPayload();
		return $this;
	}

	/**
	 * Check if the quest is available for a unit or parry.
	 */
	public function isAvailableFor(Party|Unit $subject): bool {
		return $this->prepareController()->isAvailableFor($subject);
	}

	/**
	 * Check if the quest can now be finished by a player unit.
	 */
	public function canBeFinishedBy(Unit $unit): bool {
		return $this->prepareController()->canBeFinishedBy($unit);
	}

	/**
	 * Check if a quest has been assigned to a player unit.
	 */
	public function isAssignedTo(Unit $unit): bool {
		return $this->prepareController()->isAssignedTo($unit);
	}

	/**
	 * Check if a quest has been completed by a player unit (and can be removed).
	 */
	public function isCompletedBy(Unit $unit): bool {
		return $this->prepareController()->isCompletedBy($unit);
	}

	/**
	 * Call the controller from a player unit.
	 *
	 * This should either assign the quest to a player unit or finish an assigned quest, if applicable.
	 */
	public function callFrom(Unit $unit): static {
		$this->prepareController()->callFrom($unit);
		return $this;
	}

	/**
	 * @param array<string, mixed> $data
	 */
	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::ID, Validate::Int);
		$this->validate($data, self::OWNER, Validate::Int);
		$this->validate($data, self::CONTROLLER, Validate::String);
		$this->validate($data, self::PAYLOAD, Validate::Array);
	}

	private function prepareController(): Controller {
		return $this->controller->setPayload($this);
	}
}
