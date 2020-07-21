<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Factory;

use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Exception\DuplicateIdException;
use Lemuria\Model\Exception\NotRegisteredException;
use Lemuria\Model\Lemuria\Exception\DuplicateMessageException;
use Lemuria\Model\Lemuria\LemuriaMessage;
use Lemuria\Model\Message;
use Lemuria\Model\Report;

class DefaultReport implements Report
{
	/**
	 * @var array(int=>array)
	 */
	private array $report = [];

	/**
	 * @var array(int=>LemuriaMessage)
	 */
	private array $message = [];

	/**
	 * @var int
	 */
	private int $nextId = 1;

	/**
	 * @var bool
	 */
	private bool $isLoaded = false;

	/**
	 * Init the report.
	 */
	public function __construct() {
		try {
			$reflection = new \ReflectionClass(Report::class);
			foreach ($reflection->getConstants() as $namespace) {
				if (!is_int($namespace)) {
					throw new LemuriaException('Expected integer report namespace.');
				}
				$this->report[$namespace] = [];
			}
		} catch (\ReflectionException $e) {
			throw new LemuriaException('Interface Report not found.', $e);
		}
	}

	/**
	 * Get the specified message.
	 *
	 * @param Id $id
	 * @return Message
	 * @throws NotRegisteredException
	 */
	public function get(Id $id): Message {
		if (!isset($this->message[$id->Id()])) {
			throw new NotRegisteredException($id);
		}
		return $this->message[$id->Id()];
	}

	/**
	 * Get all messages of an entity.
	 *
	 * @param Identifiable $identifiable
	 * @return array
	 */
	public function getAll(Identifiable $identifiable): array {
		$namespace = $identifiable->Catalog();
		$id        = $identifiable->Id()->Id();
		if (!isset($this->report[$namespace][$id])) {
			throw new NotRegisteredException($identifiable->Id());
		}
		return $this->report[$namespace][$id];
	}

	/**
	 * Load message data into report.
	 *
	 * @return Report
	 */
	public function load(): Report {
		if (!$this->isLoaded) {
			foreach (Lemuria::Game()->getMessages() as $data) {
				$message = new LemuriaMessage();
				$message->unserialize($data);
			}
			$this->isLoaded = true;
		}
		return $this;
	}

	/**
	 * Save game data from report.
	 *
	 * @return Report
	 */
	public function save(): Report {
		$messages = [];
		foreach ($this->message as $id => $message /* @var LemuriaMessage $message */) {
			$messages[$id] = $message->serialize();
		}
		Lemuria::Game()->setMessages($messages);
		return $this;
	}

	/**
	 * Register a message.
	 *
	 * @param Message $message
	 * @return Report
	 * @throws DuplicateIdException
	 */
	public function register(Message $message): Report {
		$namespace = $message->Report();
		$this->checkNamespace($namespace);
		$id = $message->Id()->Id();
		if (isset($this->message[$id])) {
			throw new DuplicateMessageException($message);
		}

		$this->report[$namespace][$id] = $message;
		$this->message[$id] = $message;
		if ($this->nextId === $id) {
			$this->searchNextId();
		}
		return $this;
	}

	/**
	 * Reserve the next ID.
	 *
	 * @return Id
	 */
	public function nextId(): Id {
		$id = new Id($this->nextId);
		$this->searchNextId();
		return $id;
	}

	/**
	 * Check if namespace is valid.
	 *
	 * @param int $namespace
	 * @throws LemuriaException
	 */
	private function checkNamespace(int $namespace): void {
		if (!isset($this->report[$namespace])) {
			$bug = 'Namespace ' . $namespace . ' is not a valid report namespace.';
			throw new LemuriaException($bug, new \InvalidArgumentException());
		}
	}

	/**
	 * Search for next available ID.
	 */
	private function searchNextId(): void {
		do {
			$this->nextId++;
		} while (isset($this->message[$this->nextId]));
	}
}
