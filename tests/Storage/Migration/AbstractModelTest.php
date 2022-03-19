<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Unit;

class AbstractModelTest extends BaseMigrationTest
{
	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(UnitTest::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Unit {
		$unit = new Unit();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getMissing(Unit $unit): void {
		$data    = $this->getDataMissing(UnitTest::DATA, 'isLooting', 'treasury');
		$missing = $unit->getMissing($data);

		$this->assertArray($missing, 2, 'string');
		$this->assertArrayHasKey($this->index['isLooting'], $missing);
		$this->assertSame('isLooting', $missing[$this->index['isLooting']]);
		$this->assertArrayHasKey($this->index['treasury'], $missing);
		$this->assertSame('treasury', $missing[$this->index['treasury']]);
	}

	protected function getCompleteModel(): array {
		return UnitTest::DATA;
	}
}
