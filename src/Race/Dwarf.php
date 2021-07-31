<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Glacier;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Armory;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Camouflage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Constructing;
use Lemuria\Model\Fantasya\Talent\Entertaining;
use Lemuria\Model\Fantasya\Talent\Herballore;
use Lemuria\Model\Fantasya\Talent\Horsetaming;
use Lemuria\Model\Fantasya\Talent\Magic;
use Lemuria\Model\Fantasya\Talent\Mining;
use Lemuria\Model\Fantasya\Talent\Navigation;
use Lemuria\Model\Fantasya\Talent\Quarrying;
use Lemuria\Model\Fantasya\Talent\Riding;
use Lemuria\Model\Fantasya\Talent\Roadmaking;
use Lemuria\Model\Fantasya\Talent\Shipbuilding;
use Lemuria\Model\Fantasya\Talent\Tactics;
use Lemuria\Model\Fantasya\Talent\Taxcollecting;
use Lemuria\Model\Fantasya\Talent\Trading;
use Lemuria\Model\Fantasya\Talent\Weaponry;
use Lemuria\Model\Fantasya\Talent\Woodchopping;
use Lemuria\Model\Fantasya\TerrainEffect;

/**
 * Dwarfs live in the mountains.
 */
final class Dwarf extends AbstractRace
{
	private const HITPOINTS = 25;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 110;

	private const WEIGHT = 10 * 100;

	#[Pure] public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Recruiting(): int {
		return self::RECRUITING;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] protected function mods(): array {
		return [
			Archery::class       => -1, Armory::class        =>  2, Bladefighting::class =>  1,
			Camouflage::class    => -1, Catapulting::class   =>  2, Constructing::class  =>  2,
			Entertaining::class  => -1, Herballore::class    => -2, Horsetaming::class   => -2,
			Magic::class         => -2, Mining::class        =>  2, Navigation::class    => -2,
			Quarrying::class     =>  2, Riding::class        => -2, Roadmaking::class    =>  2,
			Shipbuilding::class  => -1, Taxcollecting::class =>  1, Trading::class       =>  1,
			Weaponry::class      =>  2, Woodchopping::class  => -1
		];
	}

	protected function fill(TerrainEffect $terrainEffect): void {
		$tactics = self::createTalent(Tactics::class);

		$mountain = self::createLandscape(Mountain::class);
		$terrainEffect->add($mountain, new Modification($tactics, 1));

		$glacier = self::createLandscape(Glacier::class);
		$terrainEffect->add($glacier, new Modification($tactics, 1));
	}

}
