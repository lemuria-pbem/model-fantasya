<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Storage;

use Lemuria\Exception\LemuriaException;
use Lemuria\Storage\FileProvider;
use Lemuria\Model\Exception\ModelException;
use Lemuria\Model\Game;

/**
 * A Game implementation that stores data in JSON files.
 */
abstract class JsonGame implements Game
{
	/**
	 * @var array(string=>array)
	 */
	private array $providers = ['r' => null, 'w' => null];

	/**
	 * Initialize the storage directory.
	 */
	public function __construct() {
		$this->providers['r'] = $this->getLoadStorage();
		$this->providers['w'] = $this->getSaveStorage();
	}

	public function getCalendar(): array {
		return $this->getData('calendar.json');
	}

	public function getConstructions(): array {
		return $this->getData('constructions.json');
	}

	public function getMessages(): array {
		return $this->getData('messages.json');
	}

	public function getParties(): array {
		return $this->getData('parties.json');
	}

	public function getOrders(): array {
		return $this->getData('orders.json');
	}

	public function getRegions(): array {
		return $this->getData('regions.json');
	}

	public function getUnits(): array {
		return $this->getData('units.json');
	}

	public function getVessels(): array {
		return $this->getData('vessels.json');
	}

	public function getWorld(): array {
		return $this->getData('world.json');
	}

	public function getEffects(): array {
		return $this->getData('effects.json');
	}

	public function getStrings(): array {
		return $this->getData('strings.json');
	}

	public function setCalendar(array $calendar): Game {
		return $this->setData('calendar.json', $calendar);
	}

	public function setConstructions(array $constructions): Game {
		if (!ksort($constructions)) {
			throw new ModelException('Sorting constructions failed.');
		}
		return $this->setData('constructions.json', array_values($constructions));
	}

	public function setMessages(array $messages): Game {
		return $this->setData('messages.json', $messages);
	}

	public function setParties(array $parties): Game {
		if (!ksort($parties)) {
			throw new ModelException('Sorting parties failed.');
		}
		return $this->setData('parties.json', array_values($parties));
	}

	public function setOrders(array $orders): Game {
		return $this->setData('orders.json', $orders);
	}

	public function setRegions(array $regions): Game {
		if (!ksort($regions)) {
			throw new ModelException('Sorting regions failed.');
		}
		return $this->setData('regions.json', array_values($regions));
	}

	public function setUnits(array $units): Game {
		if (!ksort($units)) {
			throw new ModelException('Sorting units failed.');
		}
		return $this->setData('units.json', array_values($units));
	}

	public function setVessels(array $vessels): Game {
		if (!ksort($vessels)) {
			throw new ModelException('Sorting vessels failed.');
		}
		return $this->setData('vessels.json', array_values($vessels));
	}

	public function setWorld(array $world): Game {
		return $this->setData('world.json', $world);
	}

	public function setEffects(array $effects): Game {
		return $this->setData('effects.json', $effects);
	}

	/**
	 * @return array(string=>JsonProvider)
	 */
	abstract protected function getLoadStorage(): array;

	/**
	 * @return array(string=>JsonProvider)
	 */
	abstract protected function getSaveStorage(): array;

	private function getData(string $fileName): array {
		return $this->getProvider('r', $fileName)->read($fileName);
	}

	private function setData(string $fileName, array $data): JsonGame {
		$this->getProvider('w', $fileName)->write($fileName, $data);
		return $this;
	}

	private function getProvider(string $rw, string $fileName): JsonProvider {
		if (isset($this->providers[$rw][$fileName])) {
			return $this->checkProvider($this->providers[$rw][$fileName]);
		}
		if (isset($this->providers[$rw][FileProvider::DEFAULT])) {
			return $this->checkProvider($this->providers[$rw][FileProvider::DEFAULT]);
		}
		$type = $rw === 'w' ? 'write' : 'read';
		throw new LemuriaException('Default ' . $type . ' provider not defined.');
	}

	private function checkProvider(mixed $provider): JsonProvider {
		if ($provider instanceof JsonProvider) {
			return $provider;
		}
		throw new LemuriaException('JsonProvider required.');
	}
}
