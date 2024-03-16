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

	public function add(Quest $quest): static {
		$this->addEntity($quest->Id());
		return $this;
	}

	public function remove(Quest $quest): static {
		$this->removeEntity($quest->Id());
		return $this;
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
