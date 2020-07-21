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

	/**
	 * Get the calendar data.
	 *
	 * @return array
	 */
	public function getCalendar(): array {
		return $this->getData('calendar.json');
	}

	/**
	 * Get the constructions data.
	 *
	 * @return array
	 */
	public function getConstructions(): array {
		return $this->getData('constructions.json');
	}

	/**
	 * Get the report messages.
	 *
	 * @return array
	 */
	public function getMessages(): array {
		$fileName = 'messages.json';
		$path     = $this->storage . DIRECTORY_SEPARATOR . $fileName;
		if (!is_file($path)) {
			return [];
		}
		return $this->getData($fileName);
	}

	/**
	 * Get the parties data.
	 *
	 * @return array
	 */
	public function getParties(): array {
		return $this->getData('parties.json');
	}

	/**
	 * Get the regions data.
	 *
	 * @return array
	 */
	public function getRegions(): array {
		return $this->getData('regions.json');
	}

	/**
	 * Get the units data.
	 *
	 * @return array
	 */
	public function getUnits(): array {
		return $this->getData('units.json');
	}

	/**
	 * Get the vessels data.
	 *
	 * @return array
	 */
	public function getVessels(): array {
		return $this->getData('vessels.json');
	}

	/**
	 * Get the world data.
	 *
	 * @return array(array)
	 */
	public function getWorld(): array {
		return $this->getData('world.json');
	}

	/**
	 * Get string data.
	 *
	 * @return array
	 */
	public function getStrings(): array {
		return $this->getData('strings.json');
	}

	/**
	 * Set the calendar data.
	 *
	 * @param array $calendar
	 * @return Game
	 */
	public function setCalendar(array $calendar): Game {
		return $this->setData('calendar.json', $calendar);
	}

	/**
	 * Set the constructions data.
	 *
	 * @param array $constructions
	 * @return Game
	 */
	public function setConstructions(array $constructions): Game {
		if (!ksort($constructions)) {
			throw new ModelException('Sorting constructions failed.');
		}
		return $this->setData('constructions.json', array_values($constructions));
	}

	/**
	 * Set the report messages.
	 *
	 * @param array $messages
	 * @return Game
	 */
	public function setMessages(array $messages): Game {
		return $this->setData('messages.json', $messages);
	}

	/**
	 * Set the parties data.
	 *
	 * @param array $parties
	 * @return Game
	 */
	public function setParties(array $parties): Game {
		if (!ksort($parties)) {
			throw new ModelException('Sorting parties failed.');
		}
		return $this->setData('parties.json', array_values($parties));
	}

	/**
	 * Set the regions data.
	 *
	 * @param array $regions
	 * @return Game
	 */
	public function setRegions(array $regions): Game {
		if (!ksort($regions)) {
			throw new ModelException('Sorting regions failed.');
		}
		return $this->setData('regions.json', array_values($regions));
	}

	/**
	 * Set the units data.
	 *
	 * @param array $units
	 * @return Game
	 */
	public function setUnits(array $units): Game {
		if (!ksort($units)) {
			throw new ModelException('Sorting units failed.');
		}
		return $this->setData('units.json', array_values($units));
	}

	/**
	 * Set the vessels data.
	 *
	 * @param array $vessels
	 * @return Game
	 */
	public function setVessels(array $vessels): Game {
		if (!ksort($vessels)) {
			throw new ModelException('Sorting vessels failed.');
		}
		return $this->setData('vessels.json', array_values($vessels));
	}

	/**
	 * Set the world data.
	 *
	 * @param array $world
	 * @return Game
	 */
	public function setWorld(array $world): Game {
		return $this->setData('world.json', $world);
	}

	/**
	 * @return string
	 */
	abstract protected function getLoadStorage(): string;

	/**
	 * @return string
	 */
	abstract protected function getSaveStorage(): string;

	/**
	 * Get data from a file.
	 *
	 * @param string $fileName
	 * @return array(array)
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
	 *
	 * @param string $fileName
	 * @param array $data
	 * @return JsonGame
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
