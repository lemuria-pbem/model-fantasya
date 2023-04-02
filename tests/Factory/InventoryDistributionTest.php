<?php
declare(strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Factory;

use Lemuria\Model\Fantasya\Combat\BattleRow;
use Lemuria\Model\Fantasya\Commodity\Horse;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Weapon\Bow;
use Lemuria\Model\Fantasya\Commodity\Weapon\Sword;
use Lemuria\Model\Fantasya\Distribution;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Factory\InventoryDistribution;
use Lemuria\Model\Fantasya\Quantity;
use Lemuria\Model\Fantasya\Race\Human;
use Lemuria\Model\Fantasya\Resources;
use Lemuria\Tests\Model\Fantasya\Mock\UnitMock;
use Lemuria\Tests\Model\Fantasya\ModelTest;

class InventoryDistributionTest extends ModelTest
{
	use BuilderTrait;

	protected final const INVENTORY = [Bow::class => 5, Horse::class => 25, Silver::class => 506, Sword::class => 10];

	protected UnitMock $unit;

	protected function setUp(): void {
		parent::setUp();
		$this->unit = new UnitMock();
		$this->unit->setRace(self::createRace(Human::class))->setSize(10)->setBattleRow(BattleRow::Back);
		foreach (self::INVENTORY as $commodity => $count) {
			$this->unit->Inventory()->add(new Quantity(self::createCommodity($commodity), $count));
		}
	}

	/**
	 * @test
	 */
	public function construct(): InventoryDistribution {
		$inventoryDistribution = new InventoryDistribution($this->unit);

		$this->assertNotNull($inventoryDistribution);

		return $inventoryDistribution;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function distribute(InventoryDistribution $inventoryDistribution): InventoryDistribution {
		$this->assertSame($inventoryDistribution, $inventoryDistribution->distribute());

		return $inventoryDistribution;
	}

	/**
	 * @test
	 * @depends distribute
	 */
	public function getDistributions(InventoryDistribution $inventoryDistribution): void {
		$distributions = $inventoryDistribution->getDistributions();

		$this->assertArray($distributions, 3, Distribution::class);

		$unitSize  = 0;
		$resources = new Resources();
		foreach ($distributions as $distribution) {
			$size      = $distribution->Size();
			$unitSize += $size;
			foreach ($distribution as $quantity) {
				$resources->add(new Quantity($quantity->Commodity(), $size * $quantity->Count()));
			}
		}

		$this->assertSame($this->unit->Size(), $unitSize);
		$this->assertItemSet(self::INVENTORY, $resources);
	}
}
