<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Race;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Talent\Archery;
use Lemuria\Model\Lemuria\Talent\Bladefighting;
use Lemuria\Model\Lemuria\Talent\Camouflage;
use Lemuria\Model\Lemuria\Talent\Carriagemaking;
use Lemuria\Model\Lemuria\Talent\Catapulting;
use Lemuria\Model\Lemuria\Talent\Constructing;
use Lemuria\Model\Lemuria\Talent\Crossbowing;
use Lemuria\Model\Lemuria\Talent\Entertaining;
use Lemuria\Model\Lemuria\Talent\Horsetaming;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\Model\Lemuria\Talent\Navigation;
use Lemuria\Model\Lemuria\Talent\Perception;
use Lemuria\Model\Lemuria\Talent\Riding;
use Lemuria\Model\Lemuria\Talent\Roadmaking;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;
use Lemuria\Model\Lemuria\Talent\Spearfighting;
use Lemuria\Model\Lemuria\Talent\Taxcollecting;
use Lemuria\Model\Lemuria\Talent\Trading;

/**
 * Halflings are always eating.
 */
final class Halfling extends AbstractRace
{
	private const HITPOINTS = 17;

	private const PAYLOAD = 5 * 100;

	private const RECRUITING = 60;

	private const WEIGHT = 8 * 100;

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
			Archery::class        => -1, Bladefighting::class => -1, Camouflage::class   =>  1,
			Carriagemaking::class =>  2, Catapulting::class   => -1, Constructing::class =>  1,
			Crossbowing::class    =>  1, Entertaining::class  =>  1, Horsetaming::class  => -1,
			Mining::class         =>  1, Navigation::class    => -2, Perception::class   =>  1,
			Riding::class         => -1, Roadmaking::class    =>  1, Shipbuilding::class => -1,
			Spearfighting::class  =>  1, Taxcollecting::class => -1, Trading::class      =>  2
		];
	}
}
