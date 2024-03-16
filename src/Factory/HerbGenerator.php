<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Model\Fantasya\Landscape;
use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\CobaltFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\FjordFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Flatroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Gapgrowth;
use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Mandrake;
use Lemuria\Model\Fantasya\Commodity\Herb\Owlsgaze;
use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Sandreeker;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;
use Lemuria\Model\Fantasya\Commodity\Herb\Windbag;
use Lemuria\Model\Fantasya\Herb;
use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Glacier;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;
use Lemuria\Model\Fantasya\Region;

class HerbGenerator
{
	use BuilderTrait;

	private Region $region;

	private array $neighbours;

	public function setRegion(Region $region): static {
		$this->region     = $region;
		$this->neighbours = [];
		foreach (Lemuria::World()->getNeighbours($this->region) as $neighbour) {
			/** @var Region $neighbour */
			$landscape = getClass($neighbour->Landscape());
			if (!isset($this->neighbours[$landscape])) {
				$this->neighbours[$landscape] = 0;
			}
			$this->neighbours[$landscape]++;
		}
		return $this;
	}

	public function setNeighbours(string|Landscape ...$landscapes): static {
		$this->neighbours = [];
		foreach ($landscapes as $landscape) {
			$landscape = getClass($landscape);
			if (!isset($this->neighbours[$landscape])) {
				$this->neighbours[$landscape] = 0;
			}
			$this->neighbours[$landscape]++;
		}
		return $this;
	}

	public function getHerb(): ?Herb {
		$landscape = $this->region->Landscape();
		return match ($landscape::class) {
			Plain::class    => $this->calculateForPlain(),
			Forest::class   => $this->calculateForForest(),
			Highland::class => $this->calculateForHighland(),
			Mountain::class => $this->calculateForMountain(),
			Swamp::class    => $this->calculateForSwamp(),
			Desert::class   => $this->calculateForDesert(),
			Glacier::class  => $this->calculateForGlacier(),
			default         => null
		};
	}

	protected function calculateForPlain(): Herb {
		$owlsgaze = $this->count(Forest::class) + $this->count(Swamp::class);
		$flatroot = $this->count(Desert::class) + $this->count(Mountain::class);
		$temerity = $this->count(Glacier::class) + $this->count(Highland::class);
		return $this->decide([Owlsgaze::class => $owlsgaze, Flatroot::class => $flatroot, TangyTemerity::class => $temerity]);
	}

	protected function calculateForForest(): Herb {
		$fungus    = $this->count(Glacier::class) + $this->count(Swamp::class);
		$elvendear = $this->count(Highland::class) + $this->count(Plain::class);
		$ivy       = $this->count(Desert::class) + $this->count(Mountain::class);
		return $this->decide([CobaltFungus::class => $fungus, Elvendear::class => $elvendear, SpiderIvy::class => $ivy]);
	}

	protected function calculateForHighland(): Herb {
		$mandrake = $this->count(Desert::class) + $this->count(Plain::class);
		$fungus   = $this->count(Forest::class) + $this->count(Swamp::class);
		$windbag  = $this->count(Glacier::class) + $this->count(Mountain::class);
		return $this->decide([Mandrake::class => $mandrake, FjordFungus::class => $fungus, Windbag::class => $windbag]);
	}

	protected function calculateForMountain(): Herb {
		$lichen    = $this->count(Forest::class) + $this->count(Swamp::class);
		$gapgrowth = $this->count(Glacier::class) + $this->count(Highland::class);
		$rockweed  = $this->count(Desert::class) + $this->count(Plain::class);
		return $this->decide([CaveLichen::class => $lichen, Gapgrowth::class => $gapgrowth, Rockweed::class => $rockweed]);
	}

	protected function calculateForSwamp(): Herb {
		$bubblemorel = $this->count(Desert::class) + $this->count(Highland::class);
		$bugleweed   = $this->count(Forest::class) + $this->count(Plain::class);
		$knotroot    = $this->count(Glacier::class) + $this->count(Mountain::class);
		return $this->decide([Bubblemorel::class => $bubblemorel, Bugleweed::class => $bugleweed, Knotroot::class => $knotroot]);
	}

	protected function calculateForDesert(): Herb {
		$peyote      = $this->count(Highland::class) + $this->count(Plain::class);
		$sandreeker  = $this->count(Glacier::class) + $this->count(Mountain::class);
		$waterfinder = $this->count(Forest::class) + $this->count(Swamp::class);
		return $this->takeFirst([Waterfinder::class => $waterfinder, Sandreeker::class => $sandreeker, Peyote::class => $peyote]);
	}

	protected function calculateForGlacier(): Herb {
		$begonia     = $this->count(Desert::class) + $this->count(Plain::class);
		$snowcrystal = $this->count(Forest::class) + $this->count(Swamp::class);
		$hemlock     = $this->count(Highland::class) + $this->count(Mountain::class);
		return $this->takeFirst([Snowcrystal::class => $snowcrystal, IceBegonia::class => $begonia, WhiteHemlock::class => $hemlock]);
	}

	private function count(string $landscape): int {
		$landscape = getClass($landscape);
		return $this->neighbours[$landscape] ?? 0;
	}

	private function decide(array $alternatives): Herb {
		$counts = [];
		foreach ($alternatives as $class => $count) {
			if (isset($counts[$count])) {
				$counts[$count][] = $class;
			} else {
				$counts[$count] = [$class];
			}
		}
		krsort($counts);
		$classes = current($counts);
		$i       = array_rand($classes);
		return $this->createHerb($classes[$i]);
	}

	private function takeFirst(array $alternatives): Herb {
		foreach ($alternatives as $class => $count) {
			if ($count > 0) {
				return $this->createHerb($class);
			}
		}
		return $this->createHerb(key($alternatives));
	}

	private function createHerb(string $class): Herb {
		$herb = self::createCommodity($class);
		if ($herb instanceof Herb) {
			return $herb;
		}
		throw new LemuriaException('Invalid herb ' . $herb);
	}
}
