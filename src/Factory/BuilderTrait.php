<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Factory;

use Lemuria\Exception\SingletonException;
use Lemuria\Lemuria;
use Lemuria\Model\Lemuria\Building;
use Lemuria\Model\Lemuria\Building\Castle;
use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Landscape;
use Lemuria\Model\Lemuria\Race;
use Lemuria\Model\Lemuria\Ship;
use Lemuria\Model\Lemuria\Talent;

trait BuilderTrait
{
	/**
	 * Create a building singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createBuilding(string $class): Building {
		$building = Lemuria::Builder()->create($class);
		if ($building instanceof Building) {
			return $building;
		}
		throw new SingletonException($class, 'building');
	}

	/**
	 * Create a commodity singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createCastle(string $class): Castle {
		$commodity = Lemuria::Builder()->create($class);
		if ($commodity instanceof Castle) {
			return $commodity;
		}
		throw new SingletonException($class, 'castle');
	}

	/**
	 * Create a commodity singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createCommodity(string $class): Commodity {
		$commodity = Lemuria::Builder()->create($class);
		if ($commodity instanceof Commodity) {
			return $commodity;
		}
		throw new SingletonException($class, 'commodity');
	}

	/**
	 * Create a landscape singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createLandscape(string $class): Landscape {
		$landscape = Lemuria::Builder()->create($class);
		if ($landscape instanceof Landscape) {
			return $landscape;
		}
		throw new SingletonException($class, 'landscape');
	}

	/**
	 * Create a race singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createRace(string $class): Race {
		$race = Lemuria::Builder()->create($class);
		if ($race instanceof Race) {
			return $race;
		}
		throw new SingletonException($class, 'race');
	}

	/**
	 * Create a ship singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createShip(string $class): Ship {
		$ship = Lemuria::Builder()->create($class);
		if ($ship instanceof Ship) {
			return $ship;
		}
		throw new SingletonException($class, 'ship');
	}

	/**
	 * Create a talent singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createTalent(string $class): Talent {
		$talent = Lemuria::Builder()->create($class);
		if ($talent instanceof Talent) {
			return $talent;
		}
		throw new SingletonException($class, 'talent');
	}
}
