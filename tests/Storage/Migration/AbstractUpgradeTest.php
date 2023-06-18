<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use SATHub\PHPUnit\Base;

use Lemuria\Model\Fantasya\Storage\Migration\AbstractUpgrade;

use Lemuria\Model\Game;

class AbstractUpgradeTest extends Base
{
	/**
	 * @test
	 */
	public function getAll(): void {
		$upgrades = AbstractUpgrade::getAll();

		$this->assertIsArray($upgrades);
		$this->assertGreaterThan(0, count($upgrades));
		foreach ($upgrades as $class) {
			$this->assertIsString($class);
			$upgrade = new $class($this->createStub(Game::class));
			$this->assertInstanceOf(AbstractUpgrade::class, $upgrade);
		}
	}
}
