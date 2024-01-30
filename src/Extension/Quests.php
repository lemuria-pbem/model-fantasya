<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Scenario\Quest;
use Lemuria\Model\Fantasya\Scenario\Quest\Controller;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Sorting\ById;
use Lemuria\SortMode;

/**
 * Quests are offered by NPC units.
 *
 * @method Quest offsetGet(int|Id $offset)
 * @method Quest current()
 */
class Quests extends EntitySet implements Extension
{
	use BuilderTrait;
	use ExtensionTrait;

	private array $person = [];

	public function getClone(): static {
		return clone $this;
	}

	public function getAll(Controller $controller): self {
		$quests = new self();
		foreach ($this as $quest) {
			if ($quest->Controller() === $controller) {
				$quests->add($quest);
			}
		}
		return $quests;
	}

	public function add(Quest $quest, ?Unit $person = null): static {
		$id = $quest->Id();
		$this->addEntity($id);
		if ($this->hasCollector()) {
			$quest->addCollector($this->collector());
		}
		if ($person) {
			$this->person[$id->Id()] = $person->Id()->Id();
		}
		return $this;
	}

	public function remove(Quest $quest): static {
		$id = $quest->Id();
		$this->removeEntity($id);
		unset($this->person[$id->Id()]);
		return $this;
	}

	public function getPerson(Quest $quest): ?Unit {
		$id = $quest->Id()->Id();
		if (isset($this->person[$id])) {
			return Unit::get(new Id($this->person[$id]));
		}
		return null;
	}

	/**
	 * Sort the quests.
	 */
	public function sort(SortMode $mode = SortMode::ById): static {
		switch ($mode) {
			case SortMode::ById :
				$this->sortUsing(new ById());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	protected function get(Id $id): Quest {
		return Quest::get($id);
	}
}
