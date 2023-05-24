<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;

use Lemuria\Model\Fantasya\Storage\Migration\Unit;

class AbstractModelTest extends Migration
{
	#[Before]
	protected function initIndex(): void {
		$this->index = $this->getIndices(UnitTest::DATA);
	}

	#[Test]
	public function construct(): Unit {
		$unit = new Unit();

		$this->assertNotNull($unit);

		return $unit;
	}

	#[Test]
	#[Depends('construct')]
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
