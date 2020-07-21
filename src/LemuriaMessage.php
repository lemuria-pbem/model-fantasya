<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria;

use function Lemuria\getClass;
use Lemuria\Entity;
use Lemuria\Exception\LemuriaException;
use Lemuria\Exception\UnserializeException;
use Lemuria\Id;
use Lemuria\Lemuria;
use Lemuria\Model\Lemuria\Exception\EntityNotSetException;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Message;
use Lemuria\Serializable;
use Lemuria\SerializableTrait;

class LemuriaMessage implements Message, Serializable
{
	use BuilderTrait;
	use SerializableTrait;

	/**
	 * @var Id|null
	 */
	private ?Id $id = null;

	/**
	 * @var MessageType
	 */
	private MessageType $type;

	/**
	 * @var array(string=>Id)
	 */
	private array $entities = [];

	/**
	 * Get the ID.
	 *
	 * @return Id
	 */
	public function Id(): Id {
		return $this->id;
	}


	/**
	 * Get the report namespace.
	 *
	 * @return int
	 */
	public function Report(): int {
		return $this->type->Report();
	}

	/**
	 * Set the ID.
	 *
	 * @param Id $id
	 * @return Message
	 */
	public function setId(Id $id): Message {
		if ($this->id) {
			throw new LemuriaException('Cannot set ID twice.');
		}

		$this->id = $id;
		Lemuria::Report()->register($this);
		return $this;
	}

	/**
	 * Get the message text.
	 *
	 * @return string
	 */
	public function __toString(): string {
		return $this->type->render($this);
	}

	/**
	 * Get a plain data array of the model's data.
	 *
	 * @return array
	 */
	public function serialize(): array {
		$data     = ['id' => $this->Id()->Id(), 'type' => getClass($this->type)];
		$entities = [];
		foreach ($this->entities as $name => $id /* @var Id $id */) {
			$entities[$name] = $id->Id();
		}
		$data['entities'] = $entities;
		return $data;
	}

	/**
	 * Restore the model's data from serialized data.
	 *
	 * @param array $data
	 * @return Serializable
	 */
	public function unserialize(array $data): Serializable {
		$this->validateSerializedData($data);
		$this->setId(new Id($data['id']))->setType(self::createMessageType($data['type']));
		foreach ($data['entities'] as $name => $id) {
			if (!is_string($name) || !is_int($id)) {
				throw new UnserializeException();
			}
			$this->entities[$name] = new Id($id);
		}
		return $this;
	}

	/**
	 * @param string $name
	 * @return Id
	 * @throws EntityNotSetException
	 */
	public function get(string $name): Id {
		$name = getClass($name);
		if (!isset($this->entities[$name])) {
			throw new EntityNotSetException($this, $name);
		}
		return $this->entities[$name];
	}

	/**
	 * Set an entity.
	 *
	 * @param Entity $entity
	 * @param string $name
	 * @return LemuriaMessage
	 */
	public function set(Entity $entity, string $name = ''): LemuriaMessage {
		if (!$name) {
			$name = getClass($entity);
		}
		$this->entities[$name] = $entity->Id();
		return $this;
	}

	/**
	 * @param MessageType $type
	 * @return LemuriaMessage
	 */
	protected function setType(MessageType $type): LemuriaMessage {
		$this->type = $type;
		return $this;
	}

	/**
	 * Check that a serialized data array is valid.
	 *
	 * @param array (string=>mixed) &$data
	 */
	protected function validateSerializedData(&$data): void {
		$this->validate($data, 'id', 'int');
		$this->validate($data, 'type', 'string');
		$this->validate($data, 'entities', 'array');
	}

}
