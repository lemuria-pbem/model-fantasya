<?php
declare (strict_types = 1);
namespace Lemuria\Tests\Model\Fantasya\Storage\Migration;

use Lemuria\Model\Fantasya\Storage\Migration\Construction;

class ConstructionTest extends BaseMigrationTest
{
	public final const DATA = [
		'id'          => 1,
		'name'        => 'Holzfällerhütte',
		'description' => '',
		'building'    => 'Cabin',
		'size'        => 6,
		'inhabitants' => [],
		'treasury'    => [],
		'extensions'  => []
	];

	protected function setUp(): void {
		parent::setUp();
		$this->index = $this->getIndices(self::DATA);
	}

	/**
	 * @test
	 */
	public function construct(): Construction {
		$unit = new Construction();

		$this->assertNotNull($unit);

		return $unit;
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultInhabitants(Construction $construction): void {
		$this->assertSame([], $construction->getDefault('inhabitants'));
	}

	/**
	 * @test
	 * @depends construct
	 */
	public function getDefaultTreasury(Construction $construction): void {
		$this->assertSame([], $construction->getDefault('treasury'));
	}

	protected function getCompleteModel(): array {
		return self::DATA;
	}
}
