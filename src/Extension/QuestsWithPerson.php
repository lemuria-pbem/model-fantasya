<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\Id;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Scenario\Quest;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\SerializableTrait;
use Lemuria\Validate;

class QuestsWithPerson extends Quests
{
	use BuilderTrait;
	use SerializableTrait;

	private const string QUEST = 'quest';

	private const string PERSON = 'person';

	private array $person = [];

	public function serialize(): array {
		$data = parent::serialize();
		return [self::QUEST => $data, self::PERSON => $this->person];
	}

	public function unserialize(array $data): static {
		parent::unserialize($data[self::QUEST]);
		$this->person = $data[self::PERSON];
		return $this;
	}

	public function add(Quest $quest, ?Unit $person = null): static {
		parent::add($quest);
		if ($person) {
			$this->person[$quest->Id()->Id()] = $person->Id()->Id();
		}
		return $this;
	}

	public function remove(Quest $quest): static {
		parent::remove($quest);
		unset($this->person[$quest->Id()->Id()]);
		return $this;
	}

	public function getPerson(Quest $quest): ?Unit {
		$id = $quest->Id()->Id();
		if (isset($this->person[$id])) {
			return Unit::get(new Id($this->person[$id]));
		}
		return null;
	}

	protected function validateSerializedData(array $data): void {
		$this->validate($data, self::QUEST, Validate::Array);
		$this->validate($data, self::PERSON, Validate::Array);
	}
}
