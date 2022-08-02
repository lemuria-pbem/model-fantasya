<?php
/** @noinspection DuplicatedCode */
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\World;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\World\Island;
use Lemuria\Model\Fantasya\World\Island\OctagonalLocator;
use Lemuria\Model\World\MapCoordinates;

use Lemuria\Tests\Test;

class IslandTest extends Test
{
	protected static MapCoordinates $origin;

	protected static Region $region;

	protected static Region $secondRegion;

	/**
	 * Set up origin.
	 */
	public static function setUpBeforeClass(): void {
		self::$origin = new MapCoordinates(5, 5);
		self::$region = new Region();
		self::$region->setLandscape(new Plain());
		self::$secondRegion = new Region();
		self::$secondRegion->setLandscape(new Plain());
	}

	/**
	 * @test
	 */
	public function construct(): Island {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());

		$this->assertInstanceOf(Island::class, $island);

		return $island;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function origin(Island $island): void {
		$this->assertSame(self::$origin, $island->Origin());
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function width(Island $island): void {
		$this->assertSame(1, $island->Width());
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function height(Island $island): void {
		$this->assertSame(1, $island->Height());
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function size(Island $island): void {
		$this->assertSame(1, $island->Size());
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function isMapped(Island $island): void {
		$this->assertTrue($island->isMapped(self::$origin));
		$this->assertFalse($island->isMapped(self::createLocation(0, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(0, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 1)));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function containsNoOtherRegion(Island $island): void {
		$this->assertFalse($island->contains(new Region()));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function containsRegion(Island $island): void {
		$this->assertTrue($island->contains(self::$region));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function get(Island $island): void {
		$this->assertSame(self::$region, $island->get(self::$origin));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getUnmappedCoordinates(Island $island): void {
		$this->assertNull($island->get(self::createLocation(1, 0)));
	}

	/**
	 * @test
	 */
	public function extendNorth(): void {
		$island    = new Island(self::$origin, self::$region, new OctagonalLocator());
		$newHeight = $island->extendNorth();

		$this->assertSame(1 + 1, $newHeight);
		$this->assertSame(1, $island->Width());
		$this->assertSame($newHeight, $island->Height());
		$this->assertTrue($island->isMapped(self::$origin));
		$this->assertTrue($island->isMapped(self::createLocation(0, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(0, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 1)));
	}

	/**
	 * @test
	 */
	public function extendEast(): void {
		$island   = new Island(self::$origin, self::$region, new OctagonalLocator());
		$newWidth = $island->extendEast();

		$this->assertSame(1 + 1, $newWidth);
		$this->assertSame($newWidth, $island->Width());
		$this->assertSame(1, $island->Height());
		$this->assertTrue($island->isMapped(self::$origin));
		$this->assertFalse($island->isMapped(self::createLocation(0, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 1)));
		$this->assertTrue($island->isMapped(self::createLocation(1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(0, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 1)));
	}

	/**
	 * @test
	 */
	public function extendSouth(): void {
		$island    = new Island(self::$origin, self::$region, new OctagonalLocator());
		$newHeight = $island->extendSouth();

		$this->assertSame(1 + 1, $newHeight);
		$this->assertSame(1, $island->Width());
		$this->assertSame($newHeight, $island->Height());
		$this->assertTrue($island->isMapped(self::$origin));
		$this->assertFalse($island->isMapped(self::createLocation(0, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(1, -1)));
		$this->assertTrue($island->isMapped(self::createLocation(0, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 1)));
	}

	/**
	 * @test
	 */
	public function extendWest(): void {
		$island   = new Island(self::$origin, self::$region, new OctagonalLocator());
		$newWidth = $island->extendWest();

		$this->assertSame(1 + 1, $newWidth);
		$this->assertSame($newWidth, $island->Width());
		$this->assertSame(1, $island->Height());
		$this->assertTrue($island->isMapped(self::$origin));
		$this->assertFalse($island->isMapped(self::createLocation(0, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 1)));
		$this->assertFalse($island->isMapped(self::createLocation(1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(1, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(0, -1)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, -1)));
		$this->assertTrue($island->isMapped(self::createLocation(-1, 0)));
		$this->assertFalse($island->isMapped(self::createLocation(-1, 1)));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function addSame(Island $island): void {
		$this->assertSame($island, $island->add(self::$origin, self::$region));
		$this->assertSame(1, $island->Size());
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function addThrowsExceptionIfOtherAdded(Island $island): void {
		$region = new Region();
		$this->expectException(LemuriaException::class);

		$island->add(self::$origin, $region->setLandscape(new Plain()));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function addThrowsExceptionForOceans(Island $island): void {
		$region = new Region();
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(0, 1), $region->setLandscape(new Ocean()));
	}

	/**
	 * @test
	 */
	public function addNorth(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());

		$this->assertSame($island, $island->add(self::createLocation(0, 1), self::$secondRegion));
		$this->assertSame(1, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertSame(self::$origin, $island->Origin());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X(), self::$origin->Y() + 1)));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addNortheast(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(1, 1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addEast(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());

		$this->assertSame($island, $island->add(self::createLocation(1, 0), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(1, $island->Height());
		$this->assertSame(self::$origin, $island->Origin());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X() + 1, self::$origin->Y())));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addSoutheast(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(1, -1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addSouth(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());

		$this->assertSame($island, $island->add(self::createLocation(0, -1), self::$secondRegion));
		$this->assertSame(1, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertNotSame(self::$origin, $island->Origin());
		$this->assertSame(self::$origin->X(), $island->Origin()->X());
		$this->assertSame(self::$origin->Y() - 1, $island->Origin()->Y());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X(), self::$origin->Y() - 1)));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addSouthWest(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(-1, -1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addWest(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());

		$this->assertSame($island, $island->add(self::createLocation(-1, 0), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(1, $island->Height());
		$this->assertNotSame(self::$origin, $island->Origin());
		$this->assertSame(self::$origin->X() - 1, $island->Origin()->X());
		$this->assertSame(self::$origin->Y(), $island->Origin()->Y());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X() - 1, self::$origin->Y())));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addNorthWest(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(-1, 1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addNorthMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendNorth();
		$island->extendEast();

		$this->assertSame($island, $island->add(self::createLocation(0, 1), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertSame(self::$origin, $island->Origin());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X(), self::$origin->Y() + 1)));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addNortheastMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendNorth();
		$island->extendEast();
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(1, 1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addEastMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendNorth();
		$island->extendEast();

		$this->assertSame($island, $island->add(self::createLocation(1, 0), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertSame(self::$origin, $island->Origin());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X() + 1, self::$origin->Y())));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addSoutheastMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendEast();
		$island->extendSouth();
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(1, -1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addSouthMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendEast();
		$island->extendSouth();

		$this->assertSame($island, $island->add(self::createLocation(0, -1), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertNotSame(self::$origin, $island->Origin());
		$this->assertSame(self::$origin->X(), $island->Origin()->X());
		$this->assertSame(self::$origin->Y() - 1, $island->Origin()->Y());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X(), self::$origin->Y() - 1)));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addSouthWestMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendSouth();
		$island->extendWest();
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(-1, -1), self::$secondRegion);
	}

	/**
	 * @test
	 */
	public function addWestMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendNorth();
		$island->extendWest();

		$this->assertSame($island, $island->add(self::createLocation(-1, 0), self::$secondRegion));
		$this->assertSame(2, $island->Width());
		$this->assertSame(2, $island->Height());
		$this->assertNotSame(self::$origin, $island->Origin());
		$this->assertSame(self::$origin->X() - 1, $island->Origin()->X());
		$this->assertSame(self::$origin->Y(), $island->Origin()->Y());
		$this->assertSame(self::$secondRegion, $island->get(new MapCoordinates(self::$origin->X() - 1, self::$origin->Y())));
		$this->assertSame(1 + 1, $island->Size());
	}

	/**
	 * @test
	 */
	public function addNorthWestMapped(): void {
		$island = new Island(self::$origin, self::$region, new OctagonalLocator());
		$island->extendWest();
		$island->extendNorth();
		$this->expectException(LemuriaException::class);

		$island->add(self::createLocation(-1, 1), self::$secondRegion);
	}

	protected static function createLocation(int $xOffset, int $yOffset): MapCoordinates {
		return new MapCoordinates(self::$origin->X() + $xOffset, self::$origin->Y() + $yOffset);
	}
}
