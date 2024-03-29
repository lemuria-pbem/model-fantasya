<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Storage;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Exception\ModelException;
use Lemuria\Model\Fantasya\Construction;
use Lemuria\Model\Fantasya\Continent;
use Lemuria\Model\Fantasya\Market\Trade;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Realm;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;
use Lemuria\Model\Fantasya\Unicum;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Model\Fantasya\Vessel;
use Lemuria\Model\Game;
use Lemuria\Storage\Provider;

/**
 * A Game implementation that stores data in JSON files.
 */
abstract class JsonGame implements Game
{
	protected const array FILES = [
		'calendar.json', 'constructions.json', 'continents.json', 'effects.json', 'hostilities.json', 'messages.json',
		'newcomers.json', 'orders.json', 'parties.json', 'realms.json', 'regions.json', 'statistics.json',
		'trades.json', 'unica.json', 'units.json', 'vessels.json', 'world.json'
	];

	/**
	 * @var array<string, array>
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

	public function getNewcomers(): array {
		return $this->getData('newcomers.json');
	}

	public function getContinents(): array {
		return $this->getData('continents.json');
	}

	public function getHostilities(): array {
		return $this->getData('hostilities.json');
	}

	public function getUnica(): array {
		return $this->getData('unica.json');
	}

	public function getTrades(): array {
		return $this->getData('trades.json');
	}

	public function getRealms(): array {
		return $this->getData('realms.json');
	}

	public function getStatistics(): array {
		return $this->getData('statistics.json');
	}

	public function getStrings(): array {
		return $this->getData('strings.json');
	}

	public function setCalendar(array $calendar): static {
		return $this->setData('calendar.json', $calendar);
	}

	public function setConstructions(array $constructions): static {
		if (!ksort($constructions)) {
			throw new ModelException('Sorting constructions failed.');
		}
		return $this->setData('constructions.json', array_values($constructions));
	}

	public function setMessages(array $messages): static {
		return $this->setData('messages.json', $messages);
	}

	public function setParties(array $parties): static {
		if (!ksort($parties)) {
			throw new ModelException('Sorting parties failed.');
		}
		return $this->setData('parties.json', array_values($parties));
	}

	public function setOrders(array $orders): static {
		return $this->setData('orders.json', $orders);
	}

	public function setRegions(array $regions): static {
		if (!ksort($regions)) {
			throw new ModelException('Sorting regions failed.');
		}
		return $this->setData('regions.json', array_values($regions));
	}

	public function setUnits(array $units): static {
		if (!ksort($units)) {
			throw new ModelException('Sorting units failed.');
		}
		return $this->setData('units.json', array_values($units));
	}

	public function setVessels(array $vessels): static {
		if (!ksort($vessels)) {
			throw new ModelException('Sorting vessels failed.');
		}
		return $this->setData('vessels.json', array_values($vessels));
	}

	public function setWorld(array $world): static {
		return $this->setData('world.json', $world);
	}

	public function setEffects(array $effects): static {
		return $this->setData('effects.json', $effects);
	}

	public function setNewcomers(array $newcomers): static {
		return $this->setData('newcomers.json', $newcomers);
	}

	public function setContinents(array $continents): static {
		if (!ksort($continents)) {
			throw new ModelException('Sorting continents failed.');
		}
		return $this->setData('continents.json', array_values($continents));
	}

	public function setHostilities(array $hostilities): static {
		return $this->setData('hostilities.json', $hostilities);
	}

	public function setUnica(array $unica): static {
		if (!ksort($unica)) {
			throw new ModelException('Sorting unica failed.');
		}
		return $this->setData('unica.json', array_values($unica));
	}

	public function setTrades(array $trades): static {
		return $this->setData('trades.json', $trades);
	}

	public function setRealms(array $realms): static {
		if (!ksort($realms)) {
			throw new ModelException('Sorting realms failed.');
		}
		return $this->setData('realms.json', array_values($realms));
	}

	public function setStatistics(array $statistics): static {
		return $this->setData('statistics.json', $statistics);
	}

	public function migrate(): static {
		foreach ($this->getJsonFileNames() as $fileName) {
			$provider = $this->getProvider('r', $fileName);
			if (!$provider->exists($fileName)) {
				$provider = $this->getProvider('w', $fileName);
				$provider->write($fileName, []);
			}
		}

		$data = $this->getConstructions();
		if ($this->migrateData(Construction::class, $data)) {
			$this->setConstructions($data);
		}
		$data = $this->getContinents();
		if ($this->migrateData(Continent::class, $data)) {
			$this->setContinents($data);
		}
		$data = $this->getParties();
		if ($this->migrateData(Party::class, $data)) {
			$this->setParties($data);
		}
		$data = $this->getRealms();
		if ($this->migrateData(Realm::class, $data)) {
			$this->setRealms($data);
		}
		$data = $this->getRegions();
		if ($this->migrateData(Region::class, $data)) {
			$this->setRegions($data);
		}
		$data = $this->getTrades();
		if ($this->migrateData(Trade::class, $data)) {
			$this->setTrades($data);
		}
		$data = $this->getUnica();
		if ($this->migrateData(Unicum::class, $data)) {
			$this->setUnica($data);
		}
		$data = $this->getUnits();
		if ($this->migrateData(Unit::class, $data)) {
			$this->setUnits($data);
		}
		$data = $this->getVessels();
		if ($this->migrateData(Vessel::class, $data)) {
			$this->setVessels($data);
		}

		$calendar = $this->getCalendar();
		$version  = $calendar['version'];
		foreach (AbstractUpgrade::getAll() as $class) {
			/** @var AbstractUpgrade $upgrade */
			$upgrade = new $class($this);
			if ($upgrade->isPending($version)) {
				$upgrade->upgrade();
			}
		}
		return $this;
	}

	/**
	 * @return array<string, JsonProvider>
	 */
	abstract protected function getLoadStorage(): array;

	/**
	 * @return array<string, JsonProvider>
	 */
	abstract protected function getSaveStorage(): array;

	protected function checkProvider(Provider $provider): Provider {
		if ($provider instanceof JsonProvider) {
			return $provider;
		}
		throw new LemuriaException('JsonProvider required.');
	}

	protected function migrateData(string $entity, array &$data): bool {
		$migration  = new Migration($entity);
		$hasChanges = false;
		foreach ($data as $i => $model) {
			if (!$migration->isUpToDate($model)) {
				$data[$i]   = $migration->migrate($model);
				$hasChanges = true;
			}
		}
		return $hasChanges;
	}

	protected function getData(string $fileName): array {
		return $this->getProvider('r', $fileName)->read($fileName);
	}

	protected function setData(string $fileName, array $data): static {
		$this->getProvider('w', $fileName)->write($fileName, $data);
		return $this;
	}

	protected function getProvider(string $rw, string $fileName): Provider {
		if (isset($this->providers[$rw][$fileName])) {
			return $this->checkProvider($this->providers[$rw][$fileName]);
		}
		if (isset($this->providers[$rw][Provider::DEFAULT])) {
			return $this->checkProvider($this->providers[$rw][Provider::DEFAULT]);
		}
		$type = $rw === 'w' ? 'write' : 'read';
		throw new LemuriaException('Default ' . $type . ' provider not defined.');
	}

	protected function getJsonFileNames(): array {
		return self::FILES;
	}
}
