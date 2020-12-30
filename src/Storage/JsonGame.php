<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Storage;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Exception\FileException;
use Lemuria\Model\Exception\ModelException;
use Lemuria\Model\Game;

/**
 * A Game implementation that stores data in JSON files.
 */
abstract class JsonGame implements Game
{
	private string $storage;

	/**
	 * Initialize the storage directory.
	 */
	public function __construct() {
		$this->storage = $this->getLoadStorage();
		if (!$this->storage) {
			throw new FileException('Game data storage does not exist.');
		}
	}

	public function getCalendar(): array {
		return $this->getData('calendar.json');
	}

	public function getConstructions(): array {
		return $this->getData('constructions.json');
	}

	public function getMessages(): array {
		$fileName = 'messages.json';
		$path     = $this->storage . DIRECTORY_SEPARATOR . $fileName;
		if (!is_file($path)) {
			return [];
		}
		return $this->getData($fileName);
	}

	public function getParties(): array {
		return $this->getData('parties.json');
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

	abstract protected function getLoadStorage(): string;

	abstract protected function getSaveStorage(): string;

	/**
	 * Get data from a file.
	 */
	private function getData(string $fileName): array {
		$path = $this->storage . DIRECTORY_SEPARATOR . $fileName;
		if (!is_file($path)) {
			throw new FileException('Data file ' . $path . ' not found.');
		}
		$data = json_decode(file_get_contents($path), true, 8, JSON_THROW_ON_ERROR);
		if (is_array($data)) {
			return $data;
		}
		throw new FileException('Data file ' . $path . ' format error.');
	}

	/**
	 * Save data to a file.
	 */
	private function setData(string $fileName, array $data): JsonGame {
		$storage = $this->getSaveStorage();
		if (!is_dir($storage) && !mkdir($storage, 0755, true)) {
			throw new FileException('Could not create new game data directory ' . $storage . '.');
		}
		$storage = realpath($storage);
		if (!$storage) {
			throw new LemuriaException('Save directory ' . $storage . ' not found.');
		}
		$path = $storage . DIRECTORY_SEPARATOR . $fileName;
		if (file_put_contents($path, json_encode($data))) {
			return $this;
		}
		throw new FileException('Data file ' . $path . ' could not be saved.');
	}
}
