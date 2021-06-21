<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Exception\SingletonException;
use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Building\Castle;
use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Landscape;
use Lemuria\Model\Fantasya\Race;
use Lemuria\Model\Fantasya\Ship;
use Lemuria\Model\Fantasya\Spell;
use Lemuria\Model\Fantasya\Talent;

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
	 * Create a spell singleton.
	 *
	 * @throws SingletonException
	 */
	protected static function createSpell(string $class): Spell {
		$spell = Lemuria::Builder()->create($class);
		if ($spell instanceof Spell) {
			return $spell;
		}
		throw new SingletonException($class, 'spell');
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
