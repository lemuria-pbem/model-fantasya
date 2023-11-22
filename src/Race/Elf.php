<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Talent\Alchemy;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Bowmaking;
use Lemuria\Model\Fantasya\Talent\Camouflage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Perception;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Tactics;
use Lemuria\Model\Fantasya\TerrainEffect;

/**
 * Elves live in the woods.
 */
final class Elf extends AbstractRace
{
	private const int HITPOINTS = 22;

	private const int HUNGER = 6;

	private const float REFILL = 0.33;

	private const int PAYLOAD = 5 * 100;

	private const int RECRUITING = 130;

	private const int WEIGHT = 10 * 100;

	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	public function Hunger(): int {
		return self::HUNGER;
	}

	public function Refill(): float {
		return self::REFILL;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Recruiting(): int {
		return self::RECRUITING;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function mods(): array {
		return [
			Alchemy::class      => -1, Archery::class    =>  2, Armory::class      => -1,
			Bowmaking::class    =>  2, Camouflage::class =>  1, Catapulting::class => -2,
			Constructing::class => -1, Herballore::class =>  2, Horsetaming::class =>  1,
			Magic::class        =>  1, Mining::class     => -2, Navigation::class  => -1,
			Perception::class   =>  1, Quarrying::class  => -1, Roadmaking::class  => -1,
			Shipbuilding::class => -1
		];
	}

	protected function fill(TerrainEffect $terrainEffect): void {
		$forest = self::createLandscape(Forest::class);

		$perception = self::createTalent(Perception::class);
		$terrainEffect->add($forest, new Modification($perception, 1));

		$camouflage = self::createTalent(Camouflage::class);
		$terrainEffect->add($forest, new Modification($camouflage, 1));

		$tactics = self::createTalent(Tactics::class);
		$terrainEffect->add($forest, new Modification($tactics, 2));
	}
}
